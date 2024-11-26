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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string("acc_type", 15)->default("no")->nullable()->comment('cash / bank / others ');
            $table->string('name', 255)->nullable()->index();
            $table->string('code', 100)->unique()->index();
            $table->unsignedBigInteger('type')->nullable()->comment('1 => Asset, 2 => Liability, 3 => Expense, 4 => Income, 5 => Equity');
            $table->foreignId('parent_id')->nullable();
            $table->tinyInteger("level")->default(0);
            $table->string('bank_ac_name', 180)->nullable()->index()->comment('Bank Account Name');
            $table->string('ac_no', 100)->nullable()->index()->comment('Bank Account No');
            $table->string('bank_address', 300)->nullable()->index()->comment('Bank Address');
            $table->string('routing_no', 150)->nullable()->index()->comment('Bank');
            $table->string('swift_code', 150)->nullable()->index()->comment('Bank');
            $table->string('branch_code', 30)->nullable()->index()->comment('Bank');
            $table->string('cash_flow', 50)->nullable();
            $table->boolean("is_active")->default(1);
            $table->boolean("view_in_bs")->default(0)->comment('for BalanceSheet');
            $table->boolean("view_in_is")->default(0)->comment('for IncomeStatement');
            $table->boolean("view_in_trial")->default(0)->comment('for Trial Balance');
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
        Schema::dropIfExists('ledgers');
    }
};
