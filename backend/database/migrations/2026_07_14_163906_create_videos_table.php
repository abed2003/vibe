<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            // ULID instead of an auto-incrementing id for the public identifier: it is
            // sortable by creation time (unlike UUIDv4), which lets the feed/API use it
            // directly as an opaque cursor while still hiding the row's real primary key
            // (and therefore the total upload count) from API consumers.
            $table->ulid('uuid')->unique();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            // Storage location. Kept as an explicit disk+path pair (rather than a single
            // URL) so the disk can be switched per-environment (local in dev, s3 in
            // production) or per-video (e.g. migrating old videos to cold storage)
            // without rewriting stored URLs.
            $table->string('disk');
            $table->string('path');
            $table->string('thumbnail_path')->nullable();

            $table->string('original_filename');
            $table->string('mime_type');
            $table->unsignedBigInteger('size_bytes');

            // Populated asynchronously by ProcessVideoUploadJob once the file has been
            // probed; null until then.
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            // Plain strings (backed by PHP enums at the application layer) rather than a
            // native DB enum column: adding a new status/visibility value later is then a
            // zero-downtime application deploy instead of a schema migration, and the
            // column type stays portable across the sqlite (dev) / MySQL or Postgres
            // (prod) boundary.
            $table->string('status')->default('pending');
            $table->string('visibility')->default('public');

            // Denormalized counter, incremented via queued listener (see VideoViewed
            // event) instead of COUNT()-ing a views table on every read. Trades a small
            // amount of eventual consistency for O(1) reads on the hottest query path
            // (rendering a feed of videos).
            $table->unsignedBigInteger('views_count')->default(0);

            $table->text('failure_reason')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            // Soft deletes: user-generated content needs a moderation/undo window
            // (accidental delete, takedown appeal) before the row and its file are
            // actually purged by a separate retention job.
            $table->softDeletes();

            // Public feed query: WHERE visibility = ? AND status = ? ORDER BY published_at DESC.
            $table->index(['visibility', 'status', 'published_at']);
            // Profile page query: WHERE user_id = ? ORDER BY created_at DESC.
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
