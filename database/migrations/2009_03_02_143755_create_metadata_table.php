<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('metadata', function (Blueprint $table) {
        $table->id();
        $table->string('device_name')->nullable();
        $table->string('gps_latitude')->nullable();
        $table->string('gps_longitude')->nullable();
        $table->string('city')->nullable();
        $table->string('road')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata');
    }
};
