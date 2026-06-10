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
            $table->timestamps();
            $table->string('isbn')->unique();
            $table->string('title');
            $table->foreignId('author_id')
                ->constrained()
                ->restrictOnDelete();
            $table->decimal('price', 12, 2);
            $table->integer('quantity')->default(0);
            $table->integer('borrowed_quantity')->default(0);
            $table->integer('available_quantity')->default(0);
            $table->date('publish_date');
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', [
                'available',
                'unavailable'
            ])->default('available');
            $table->softDeletes();
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
