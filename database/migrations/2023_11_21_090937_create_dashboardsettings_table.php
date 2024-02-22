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
        Schema::create('dashboardsettings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->boolean('email_notification')->default(false);
            $table->boolean('new_order_accept_sms')->default(false);
            $table->boolean('new_order_cancel_sms')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboardsettings');
    }
};
