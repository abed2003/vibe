<?php

namespace App\Enums;

/**
 * Who can see a video once it is ready. Distinct from VideoStatus: a video can
 * be "ready" but still "private" (owner-only) or "unlisted" (viewable via
 * direct link, excluded from public feeds/search).
 */
enum VideoVisibility: string
{
    case Public = 'public';
    case Unlisted = 'unlisted';
    case Private = 'private';
}
