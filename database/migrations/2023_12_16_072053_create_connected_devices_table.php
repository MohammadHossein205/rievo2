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
        Schema::create('connecteddevices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('browser_name');
            $table->string('device');
            $table->string('ip');
            $table->text('user_location');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connected_devices');
    }
};
