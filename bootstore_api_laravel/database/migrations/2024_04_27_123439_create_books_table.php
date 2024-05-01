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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->string('cover_image')->default('https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL._AC_SX184_.jpg');
            $table->integer('price');
            // $table->json('tag')->nullable();
            // $table->enum('tag',['fiction','non-fiction','science', 'essay'])->default('fiction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
