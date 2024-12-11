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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_ledger_id')->default(0);
            $table->foreignId('selling_ledger_id')->default(0);
            $table->foreignId('product_unit_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('type', 25)->comment('Service / Product');
            $table->enum('is_active', ['Yes', 'No']);
            $table->enum('for_selling', ['Yes', 'No']);
            $table->enum('for_purchase', ['Yes', 'No']);
            $table->enum('stock_manage', ['Yes', 'No']);
            $table->double('selling_price', 28,2)->default(0)->index();
            $table->double('purchase_price', 28,2)->default(0)->index();
            $table->string('image',300)->nullable();
            $table->text('details')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
