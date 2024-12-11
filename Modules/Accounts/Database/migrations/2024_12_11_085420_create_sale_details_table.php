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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("sale_id")->default(0);
            $table->foreignId("product_id")->default(0);
            $table->integer('quantity')->default(0);
            $table->double('tax', 10,2)->default(0)->comment('in percentage');
            $table->double('discount', 10,2)->default(0)->comment('in percentage');
            $table->double('per_price', 28,2)->default(0);
            $table->double('total_price', 28,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
