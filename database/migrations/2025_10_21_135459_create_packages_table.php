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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number', 500)->nullable();
            $table->string('courier_name');
            $table->string('logo');
            $table->string('address');
            $table->string('reference', 500)->nullable();
            $table->string('guide_domain', 20);
            $table->string('client_domain', 20);
            $table->unsignedBigInteger('client_code');
            $table->timestamps();

            $table->foreignId('shop_id')->constrained();
            $table->foreignId('package_category_id')->constrained();
            $table->foreignId('shipping_method_id')->constrained();
            $table->foreignId('waybill_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
