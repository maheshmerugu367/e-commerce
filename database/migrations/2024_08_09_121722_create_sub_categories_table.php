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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Ensuring title is unique
            $table->unsignedBigInteger('category_id'); // Foreign key reference to categories
            $table->string('app_icon')->nullable();
            $table->string('web_icon')->nullable();
            $table->string('main_image')->nullable();
            $table->string('priority');
            $table->string('front_status')->nullable();
            $table->Integer('status')->comment('Status: 1 for active, 0 for inactive')->default(1);
            $table->Integer('trash')->default(1);
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
