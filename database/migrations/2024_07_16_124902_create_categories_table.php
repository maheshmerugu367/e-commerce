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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique(); // Ensuring title is unique
            $table->string('app_icon');
            $table->string('menu_image');
            $table->string('app_main_image');
            $table->string('priority');
            $table->string('status')->comment('Status: 1 for active, 2 for inactive');
            $table->bigInteger('parent_id');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
