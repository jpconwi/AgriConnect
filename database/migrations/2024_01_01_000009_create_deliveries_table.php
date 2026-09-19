<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('courier_name')->nullable();
            $table->string('tracking_number')->unique();
            $table->enum('status', ['preparing', 'in_transit', 'delivered'])->default('preparing');
            $table->string('current_location')->nullable();
            $table->date('estimated_arrival')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
