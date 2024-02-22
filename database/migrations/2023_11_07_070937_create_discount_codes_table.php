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
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('discount_code', 10);
            $table->integer('price');
            $table->smallInteger('count');
            $table->date('end_time');
            $table->timestamps();
        });
        Schema::create('discount_codeables', function (Blueprint $table) {
            $table->bigInteger('discount_code_id');
            $table->bigInteger('discount_codeables_id');
            $table->string('discount_codeables_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
