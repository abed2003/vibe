<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

/**
 * Raised when probing or transcoding a video fails. Distinguishes permanent
 * failures (corrupt/unsupported file — retrying will never succeed) from
 * transient ones (disk contention, a process that failed to start — retrying
 * may succeed), so ProcessVideoUploadJob knows whether to burn its retry
 * budget or fail fast.
 */
class VideoProcessingException extends RuntimeException
{
    private function __construct(string $message, private readonly bool $permanent, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function permanent(string $message, ?Throwable $previous = null): self
    {
        return new self($message, permanent: true, previous: $previous);
    }

    public static function transient(string $message, ?Throwable $previous = null): self
    {
        return new self($message, permanent: false, previous: $previous);
    }

    public function isPermanent(): bool
    {
        return $this->permanent;
    }
}
