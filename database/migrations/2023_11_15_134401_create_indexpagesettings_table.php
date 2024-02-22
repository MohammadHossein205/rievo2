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
        Schema::create('indexpagesettings', function (Blueprint $table) {
            $table->id();
            $table->string('top_big_text');
            $table->string('top_small_text');
            $table->text('top_big_description');
            $table->text('estelam_text');
            $table->text('baner_one_image');
            $table->text('baner_one_image_link');
            $table->text('baner_two_image');
            $table->text('baner_two_image_link');
            $table->string('more_information_title');
            $table->text('more_information_text');
            $table->string('phone_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indexpagesettings');
    }
};
