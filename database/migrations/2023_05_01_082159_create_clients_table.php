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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('number')->unique();
            $table->integer('verification_code')->nullable();
            $table->timestamp('number_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('push_token')->nullable();
            $table->string('noti_image')->nullable();
            $table->string('image')->nullable();
            $table->string('userType')->default('user');
            $table->double('rate')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
