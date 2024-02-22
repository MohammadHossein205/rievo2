<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->integer('size');
            $table->text('path');
            $table->text('url');
            $table->text('format');
            $table->timestamps();
        });
        Schema::create('galleryables', function (Blueprint $table) {
            $table->bigInteger('gallery_id');
            $table->bigInteger('galleryables_id');
            $table->string('galleryables_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
