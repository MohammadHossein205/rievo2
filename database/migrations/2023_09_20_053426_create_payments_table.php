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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('payment_type');
            $table->string('resNumber');
            $table->smallInteger('discount');
            $table->integer('discount_price');
            $table->bigInteger('price');
            $table->string('card_number');
            $table->boolean('IsMonthly')->default(0);
            $table->boolean('status');
            $table->boolean('buyorsell');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
