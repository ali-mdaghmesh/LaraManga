<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('last_watchings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('manga_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId('chapter_id')->nullable()->constrained()->nullOnDelete(); 
             $table->unsignedInteger('last_page_read')->default(1);
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('last_watchings');
    }
};
