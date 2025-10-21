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
        Schema::create('waybills', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 7, 2);
            $table->decimal('weight', 7, 2);
            $table->unsignedInteger('items_count');
            $table->string('description', 1000);
            $table->string('status', 50);

            $table->foreignId('package_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waybills');
    }
};
