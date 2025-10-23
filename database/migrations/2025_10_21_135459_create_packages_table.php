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
            $table->string('status', 50);
            $table->string('tracking_number', 500)->nullable();
            $table->string('courier_name');
            $table->string('logo');
            $table->string('shipping_address', 1000);
            $table->string('reference', 500)->nullable();
            $table->string('guide_domain', 20);
            $table->string('client_domain', 20);
            $table->unsignedBigInteger('client_code');
            $table->string('client_identity_card', 30);
            $table->string('client_name');
            $table->string('client_lastname');
            $table->timestamps();

            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shipping_method_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
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
