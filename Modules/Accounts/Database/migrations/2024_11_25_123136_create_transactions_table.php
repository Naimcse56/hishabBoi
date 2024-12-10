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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(date("Y-m-d"))->index();
            $table->unsignedBigInteger('voucher_id')->unsigned();
            $table->unsignedBigInteger("work_order_id")->default(0);
            $table->unsignedBigInteger("work_order_site_id")->default(0);
            $table->unsignedBigInteger('ledger_id')->default(0);
            $table->integer('sub_ledger_id')->default(0);
            $table->string('type',20)->nullable()->comment('dr / cr');
            $table->unsignedBigInteger("credit_period")->nullable()->comment('in days');
            $table->double('amount', 28,2)->default(0)->index();
            $table->text('narration')->nullable();
            $table->boolean('is_opening')->default(0);
            $table->boolean('is_approve')->default(0)->comment('0 => pending, 1 => Approve, 2 => Cancelled');
            $table->string('bank_name',255)->nullable();
            $table->string('bank_account_name',255)->nullable();
            $table->string('check_no',200)->nullable();
            $table->date('check_mature_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
