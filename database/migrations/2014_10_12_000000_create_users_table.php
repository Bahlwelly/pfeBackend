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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('password')->nullable();
            $table->string('role')->nullable();
            $table->integer('signal')->nullable();
            $table->bigInteger('nni')->unique()->nullable();
            $table->bigInteger('tel')->unique();
            $table->string('commune')->nullable();
            $table->string('blocquee')->nullable();
            $table->integer('code')->nullable();
            $table->dateTime('code_expire_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
