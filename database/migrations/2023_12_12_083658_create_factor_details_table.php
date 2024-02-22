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
        Schema::create('factor_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('factor_id');
            $table->bigInteger('factortable_id');
            $table->string('factortable_type');
            $table->integer('count');
            $table->integer('monthly_money')->default(0);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factor_details');
    }
};
