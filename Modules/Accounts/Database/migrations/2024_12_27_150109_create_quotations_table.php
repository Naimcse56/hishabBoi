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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(date("Y-m-d"))->index();
            $table->foreignId("sub_ledger_id")->nullable()->comment('supplier_id');
            $table->string('invoice_no',100)->nullable()->index();
            $table->string('ref_no',100)->nullable();
            $table->string('phone',15)->nullable()->comment('supplier phone');
            $table->double('total_amount', 28,2)->default(0)->index();
            $table->double('payable_amount', 28,2)->default(0)->index();
            $table->double('discount_amount', 28,2)->default(0);
            $table->double('discount_percentage', 8,2)->default(0);
            $table->enum('payment_method', ['Cash', 'Bank', 'Due', 'Online']);
            $table->enum('payment_status', ['Paid', 'Partial', 'Due']);
            $table->text('note')->nullable();
            $table->text('terms_condition')->nullable();
            $table->unsignedBigInteger("credit_period")->nullable(0)->comment('in days');
            $table->enum('is_approved', ['Pending', 'Approved', 'Rejected']);
            $table->enum('is_convert_to_sale', ['Pending', 'Converted', 'Rejected']);
            $table->foreignId("approved_by")->nullable();
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
        Schema::dropIfExists('quotations');
    }
};
