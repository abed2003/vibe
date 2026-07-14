<?php

namespace App\Enums;

/**
 * Lifecycle of an uploaded video file, from initial upload through async
 * processing (metadata extraction + thumbnail generation) to being servable.
 */
enum VideoStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Ready = 'ready';
    case Failed = 'failed';

    public function isTerminal(): bool
    {
        return match ($this) {
            self::Ready, self::Failed => true,
            self::Pending, self::Processing => false,
        };
    }
}
