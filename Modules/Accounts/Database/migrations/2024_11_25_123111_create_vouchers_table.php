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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(date("Y-m-d"))->index();
            $table->string('panel', 50)->nullable();
            $table->integer('f_year')->nullable()->comment('get understand the financial year');
            $table->integer('txn_id')->nullable()->index();
            $table->string('referable_type')->nullable();
            $table->unsignedBigInteger('referable_id')->nullable();
            $table->string('type')->nullable()->comment('pay_cash / pay_bank / rcv_cash / rcv_bank / misc / contra / cash / bank / payable / receivable / purchase / sales');
            $table->double('amount', 28,2)->default(0)->index();
            $table->string('ref_no', 150)->nullable();
            $table->text('narration')->nullable();
            $table->text('rejection_comment')->nullable();
            $table->tinyInteger('is_approve')->default(0)->comment('0 => pending, 1 => Approve, 2 => Cancelled');
            $table->boolean('is_transfer')->default(0)->comment('money transfer from here to there');
            $table->boolean('is_invoiced')->default(0);
            $table->boolean("is_advanced")->default(0);
            $table->boolean("is_opening")->default(0);
            $table->boolean("is_manual_entry")->default(0);
            $table->boolean("is_work_order_based")->default(0)->comment('general journal / work order journal');
            $table->string("pay_or_rcv_type", 100)->nullable()->comment('online transaction / cash / check');
            $table->string('concern_person',255)->nullable();
            $table->string('mac_address',255)->nullable();
            $table->string('ip',255)->nullable();
            $table->text('attachment')->nullable();
            $table->foreignId("approved_by")->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
