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
        Schema::create('sub_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_ledger_type_id')->default(0);
            $table->string('morphable_type')->nullable();
            $table->unsignedBigInteger('morphable_id')->default(0);
            $table->unsignedBigInteger("ledger_id")->nullable();
            $table->string('code',80)->nullable()->index();
            $table->string('name',255)->nullable()->index();
            $table->string('email',255)->nullable()->index();
            $table->string('bank_name', 300)->nullable()->index()->comment('Bank Name');
            $table->string('bank_ac_name', 300)->nullable()->index()->comment('Bank Account');
            $table->string('routing_no', 150)->nullable()->index()->comment('Bank');
            $table->string('swift_code', 150)->nullable()->index()->comment('Bank');
            $table->string('branch_code', 30)->nullable()->index()->comment('Bank');
            $table->boolean("is_active")->default(1);
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
        Schema::dropIfExists('sub_ledgers');
    }
};
