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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_price', 10, 2);

            // Add the customer_id column
            $table->unsignedBigInteger('customer_id'); // Define the column first
            $table->foreign('customer_id')->references('id')->on('customers'); // Then create the foreign key

            $table->timestamp('order_date');
            $table->softDeletes(); // For SoftDeletes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
