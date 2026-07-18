<?php

namespace Database\Seeders;

use App\Enums\VideoStatus;
use App\Enums\VideoVisibility;
use App\Models\Comment;
use App\Models\Follow;
use App\Models\Like;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;

/**
 * Seeds a realistic demo feed: six creator accounts and one video each,
 * pointing at real MP4 files shipped in storage/app/public/videos (downloaded
 * sample clips — real bytes served through the app's own public disk, so the
 * feed is genuinely playable end-to-end). Engagement rows (likes, comments,
 * follows) are created and the denormalized counters synced to match.
 */
class DemoSeeder extends Seeder
{
    /**
     * filename => [title, description, tags, duration_seconds, creator key]
     */
    private const VIDEOS = [
        'big-buck-bunny.mp4' => [
            'Big Buck Bunny — forest mischief',
            'A giant rabbit wakes up to a beautiful morning, and the rodents start plotting.',
            ['animation', 'nature', 'blender'],
            10,
            'leo',
        ],
        'big-buck-bunny-2.mp4' => [
            'Big Buck Bunny — extended chase',
            'The butterfly chase, but with the higher-bitrate cut. Worth it for the lighting.',
            ['animation', 'comedy', 'blender'],
            10,
            'overland',
        ],
        'jellyfish.mp4' => [
            'Jellyfish drift',
            'No edits, no music — just ten seconds of pure underwater calm.',
            ['underwater', 'nature', 'relax'],
            10,
            'noor',
        ],
        'jellyfish-2.mp4' => [
            'Jellyfish — deep blue cut',
            'The extended grade with deeper blues. Sound on for this one.',
            ['underwater', 'ocean', 'calm'],
            10,
            'priya',
        ],
        'sintel.mp4' => [
            'Sintel — the search',
            'Recut the trailer with a score that finally matches the heartbreak.',
            ['film', 'cinematic', 'fantasy'],
            10,
            'maya',
        ],
        'sintel-2.mp4' => [
            'Sintel — extended trailer',
            'The longer cut, because ten seconds was never going to be enough.',
            ['film', 'trailer', 'blender'],
            10,
            'rin',
        ],
    ];

    private const USERS = [
        'maya' => ['Maya Flux', 'maya@tikvibe.test', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=160&q=80'],
        'rin' => ['Rin Audio', 'rin@tikvibe.test', 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?auto=format&fit=crop&w=160&q=80'],
        'noor' => ['Noor Lane', 'noor@tikvibe.test', 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=160&q=80'],
        'leo' => ['Leo Marlow', 'leo@tikvibe.test', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=160&q=80'],
        'priya' => ['Priya Stone', 'priya@tikvibe.test', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=160&q=80'],
        'overland' => ['Overland Co', 'crew@tikvibe.test', 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=160&q=80'],
    ];

    private const COMMENT_BODIES = [
        'This whole edit feels expensive in the best way.',
        'The lighting shift at the drop is perfect.',
        'Tutorial when? I need this in my life.',
        'Instant follow. The pacing is unreal.',
        'Watching this for the fifth time today.',
        'The recovery at the end deserves an award.',
        'This is the sign I needed to take the long way home.',
    ];

    public function run(): void
    {
        $users = collect(self::USERS)->mapWithKeys(
            fn ($data, $key) => [$key => User::factory()->create([
                'name' => $data[0],
                'email' => $data[1],
                'avatar_url' => $data[2],
            ])]
        );

        $disk = 'public';
        $storageRoot = storage_path("app/{$disk}/videos");

        $videos = collect(self::VIDEOS)->mapWithKeys(function ($meta, $filename) use ($users, $disk, $storageRoot) {
            $path = "{$storageRoot}/{$filename}";

            // Seed only videos whose file is actually present — a missing file
            // must never produce a broken (fake) feed entry.
            if (! is_file($path)) {
                $this->command?->warn("DemoSeeder: skipped [{$filename}] — file missing at {$path}.");

                return [];
            }

            $video = Video::forceCreate([
                'user_id' => $users[$meta[4]]->id,
                'title' => $meta[0],
                'description' => $meta[1],
                'tags' => $meta[2],
                'visibility' => VideoVisibility::Public,
                'disk' => $disk,
                'path' => "videos/{$filename}",
                'thumbnail_path' => null,
                'original_filename' => $filename,
                'mime_type' => 'video/mp4',
                'size_bytes' => filesize($path) ?: 0,
                'duration_seconds' => $meta[3],
                'width' => 1920,
                'height' => 1080,
                'status' => VideoStatus::Ready,
                'views_count' => random_int(2_400, 96_000),
                'published_at' => now()->subHours(random_int(3, 96)),
            ]);

            return [$filename => $video];
        })->sortByDesc('published_at');

        // Engagement: every video gets likes + comments from other creators,
        // and the creators follow each other in a loose web.
        $allUsers = $users->values();

        foreach ($videos as $video) {
            $likers = $allUsers->where('id', '!=', $video->user_id)->shuffle()->take(random_int(3, 5));

            foreach ($likers as $liker) {
                Like::firstOrCreate(['video_id' => $video->id, 'user_id' => $liker->id]);
            }

            $video->forceFill(['likes_count' => $video->likes()->count()])->save();

            $commenters = $allUsers->where('id', '!=', $video->user_id)->shuffle()->take(random_int(2, 3));
            $bodies = collect(self::COMMENT_BODIES)->shuffle();

            foreach ($commenters as $index => $commenter) {
                Comment::create([
                    'video_id' => $video->id,
                    'user_id' => $commenter->id,
                    'body' => $bodies[$index],
                    'created_at' => $video->published_at->copy()->addHours(random_int(1, 20)),
                    'updated_at' => $video->published_at->copy()->addHours(random_int(1, 20)),
                ]);
            }

            $video->forceFill(['comments_count' => $video->comments()->count()])->save();
        }

        foreach ($allUsers as $index => $user) {
            foreach ($allUsers as $otherIndex => $other) {
                if ($index !== $otherIndex && ($index + $otherIndex) % 2 === 0) {
                    Follow::firstOrCreate(['follower_id' => $user->id, 'following_id' => $other->id]);
                }
            }
        }
    }
}
