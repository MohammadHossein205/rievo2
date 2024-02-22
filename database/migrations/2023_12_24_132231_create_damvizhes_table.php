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
        Schema::create('damvizhes', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');
            $table->integer('group_company_id');
            $table->foreignId('user_id')->default(1);
            $table->string('name');
            $table->string('slug');
            $table->string('code');
            $table->bigInteger('price');
            $table->double('weight');
            $table->string('color', 50);
            $table->string('colorenglish', 50);
            $table->integer('ageYear');
            $table->integer('ageMonth');
            $table->boolean('gender');
            $table->boolean('haveMilk')->nullable();
            $table->double('milk_amount')->nullable();
            $table->longText('description');
            $table->bigInteger('disount_price');
            $table->date('disount_time');
            $table->boolean('status')->default();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damvizhes');
    }
};
