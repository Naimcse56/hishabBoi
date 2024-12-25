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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(date("Y-m-d"))->index();
            $table->string('morphable_type')->nullable();
            $table->unsignedBigInteger('morphable_id')->nullable();
            $table->double('amount', 28,2)->default(0)->index();
            $table->unsignedBigInteger('ledger_id')->default(0);
            $table->string('bank_name',255)->nullable();
            $table->string('bank_account_name',255)->nullable();
            $table->string('check_no',200)->nullable();
            $table->date('check_mature_date')->nullable();
            $table->tinyInteger('is_approve')->default(0)->comment('0 => pending, 1 => Approve, 2 => Cancelled');
            $table->string('mac_address',255)->nullable();
            $table->string('ip',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
