<?php

namespace App\Policies;

use App\Enums\VideoVisibility;
use App\Models\User;
use App\Models\Video;

class VideoPolicy
{
    /**
     * Public videos are viewable by anyone (including guests); unlisted
     * videos are viewable by anyone who has the link (they're excluded from
     * the feed/search, not access-controlled); private videos are
     * owner-only.
     */
    public function view(?User $user, Video $video): bool
    {
        return match ($video->visibility) {
            VideoVisibility::Public, VideoVisibility::Unlisted => true,
            VideoVisibility::Private => $video->isOwnedBy($user),
        };
    }

    public function delete(User $user, Video $video): bool
    {
        return $video->isOwnedBy($user);
    }
}
