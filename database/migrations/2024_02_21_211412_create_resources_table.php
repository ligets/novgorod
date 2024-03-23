<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 64)->nullable();
            $table->string('pathPreview')->nullable()->index();
            $table->string('path');
            $table->string('format', 15);
            $table->unsignedBigInteger('metadata_id')->nullable();
            $table->boolean('in_album')->default(false);
            $table->unsignedBigInteger('type_id');
            $table->timestamps();

            $table->foreign('metadata_id')->references('id')->on('metadata')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
