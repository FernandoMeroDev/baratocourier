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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50);
            $table->date('shipping_date');
            $table->string('reference');
            $table->dateTime('shipment_datetime')->nullable();
            $table->dateTime('upshipment_datetime')->nullable();
            $table->string('status', 50);
            $table->date('arrival_min_date');
            $table->date('arrival_max_date');
            $table->timestamps();

            $table->foreignId('shipment_type_id');
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
