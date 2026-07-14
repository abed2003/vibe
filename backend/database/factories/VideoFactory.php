<?php

namespace Database\Factories;

use App\Enums\VideoStatus;
use App\Enums\VideoVisibility;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->boolean(70) ? $this->faker->paragraph() : null,
            'disk' => 'local',
            'path' => 'videos/'.$this->faker->uuid().'.mp4',
            'thumbnail_path' => null,
            'original_filename' => $this->faker->lexify('clip_????????').'.mp4',
            'mime_type' => 'video/mp4',
            'size_bytes' => $this->faker->numberBetween(500_000, 50_000_000),
            'duration_seconds' => null,
            'width' => null,
            'height' => null,
            'status' => VideoStatus::Pending,
            'visibility' => VideoVisibility::Public,
            'views_count' => 0,
            'failure_reason' => null,
            'published_at' => null,
        ];
    }

    /**
     * A video that has finished processing and is publicly viewable.
     */
    public function ready(): static
    {
        return $this->state(fn () => [
            'status' => VideoStatus::Ready,
            'thumbnail_path' => 'thumbnails/'.$this->faker->uuid().'.jpg',
            'duration_seconds' => $this->faker->numberBetween(5, 180),
            'width' => 1080,
            'height' => 1920,
            'published_at' => now(),
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn () => [
            'status' => VideoStatus::Failed,
            'failure_reason' => 'ffprobe exited with a non-zero status.',
        ]);
    }

    public function private(): static
    {
        return $this->state(fn () => ['visibility' => VideoVisibility::Private]);
    }
}
