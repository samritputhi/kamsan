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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->unsignedBigInteger('category_id');
            $table->foreign("category_id")->references("id")->on("categories");
            $table->Integer("order");
            $table->boolean("status");
            $table->string("image")->nullable();
            $table->text("des")->nullable();
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
