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
        Schema::create('franchisees', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 10);
            $table->string('courier_name');
            $table->string('logo')->nullable();
            $table->string('address', 500);
            $table->string('guide_domain', 20);
            $table->string('client_domain', 20);
            $table->unsignedBigInteger('next_waybill_number')->default(1);
            $table->string('waybill_text_reference', 50);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('franchisees');
    }
};
