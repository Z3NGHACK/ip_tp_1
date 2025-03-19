<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_price', 10, 2);
            $table->unsignedBigInteger('customer_id');
            $table->timestamp('order_date');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
