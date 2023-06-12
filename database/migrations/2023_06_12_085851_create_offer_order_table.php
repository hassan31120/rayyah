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
        Schema::create('offer_order', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('delivery_id');
            $table->integer('client_id');
            $table->float('price')->default(0.0);
            $table->time('est_time');
            $table->enum('status',['pending','accepted' , 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_order');
    }
};
