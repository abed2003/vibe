<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            // Denormalized counters, same trade-off as the existing views_count:
            // O(1) reads on the feed path instead of COUNT() joins per row.
            $table->unsignedBigInteger('likes_count')->default(0)->after('views_count');
            $table->unsignedBigInteger('comments_count')->default(0)->after('likes_count');

            // Creator-supplied hashtags; json keeps this portable across
            // sqlite/MySQL/Postgres like the status/visibility string columns.
            $table->json('tags')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['likes_count', 'comments_count', 'tags']);
        });
    }
};
