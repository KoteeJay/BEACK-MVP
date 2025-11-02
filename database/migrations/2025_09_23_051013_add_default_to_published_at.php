<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'published_at')) {
                $table->timestamp('published_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->after('created_at'); // Add it with default value
            } else {
                $table->timestamp('published_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->change(); // Ensure it has the default value
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
           if (Schema::hasColumn('posts', 'published_at')) {
                $table->dropColumn('published_at'); // Drop the column if it exists
            }
        });
    }
};
