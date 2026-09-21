<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mangas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('source', ['mangadex', 'local']);
            $table->string('mangadex_id')->nullable()->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('author_name')->nullable();
            $table->string('artist_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};