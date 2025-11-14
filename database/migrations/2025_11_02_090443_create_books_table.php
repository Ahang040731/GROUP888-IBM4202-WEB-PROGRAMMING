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

            $table->string('book_name'); // or simply 'title'
            $table->string('photo')->nullable(); // store image path or URL
            $table->string('author')->nullable();
            $table->year('published_year')->nullable();
            $table->text('description')->nullable();
            $table->float('rating', 2, 1)->default(0); // e.g. 4.5
            $table->string('category')->nullable();

            $table->unsignedSmallInteger('total_copies')->default(0);
            $table->unsignedSmallInteger('available_copies')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
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
