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
        Schema::create('resource_tags', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('resource_id')->index();
            $table->unsignedBigInteger('tag_id')->index();

            $table->foreign('resource_id')->references('id')->on('resources');
            $table->foreign('tag_id')->references('id')->on('tags');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_tags');
    }
};
