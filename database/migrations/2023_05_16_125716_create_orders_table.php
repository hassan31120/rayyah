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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_method', ['cod', 'visa', 'wallet']);
            $table->float('total_del_price')->default(0.0);
            $table->float('total_service_price')->default(0.0);
            $table->float('total_cost')->default(0.0);
            $table->Text('description');

            $table->enum('status', ['pending', 'on_delivery', 'done', 'cancelled'])->default('pending');
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('address_id');
            $table->string('ref_number')->nullable();

            $table->foreign('delivery_id')->references('id')->on('clients')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
