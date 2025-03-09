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
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string('computer_name');
            $table->string('operating_system');
            $table->string('model');
            $table->string('mac_address')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('disk_size');
            $table->string('ram');
            $table->string('serial_number')->nullable();
            $table->string('site_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};
