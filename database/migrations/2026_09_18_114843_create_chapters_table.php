<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('manga_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('mangadex_id')->nullable();
            $table->enum('source', ['local', 'mangaDex']);
            $table->float('chapter_number');
            $table->string('title')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};