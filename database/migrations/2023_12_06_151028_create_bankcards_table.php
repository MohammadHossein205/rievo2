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
        Schema::create('bankcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('bankname');
            $table->text('image');
            $table->bigInteger('cardnumber');
            $table->string('shabanumber');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankcards');
    }
};
