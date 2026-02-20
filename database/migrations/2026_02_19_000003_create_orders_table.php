<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('menu_name');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('base_amount');
            $table->unsignedInteger('extra_amount')->default(0);
            $table->unsignedInteger('total_amount');
            $table->string('payment_method'); // qris / kasir
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
