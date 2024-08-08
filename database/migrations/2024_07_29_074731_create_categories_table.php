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
                $table->string('title'); // Ensuring title is unique
                $table->string('app_icon');
                $table->string('web_icon');
                $table->string('main_image');
                $table->string('priority');
                $table->Integer('status')->comment('Status: 1 for active, 0 for inactive')->default(1);
                $table->Integer('trash')->default(1);
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
