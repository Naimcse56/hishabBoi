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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(date("Y-m-d"))->index();
            $table->date('final_date')->default(date("Y-m-d"))->index();
            $table->unsignedBigInteger("sub_ledger_id")->comment('client id');
            $table->string('awarded_by',255)->nullable()->index()->comment('the man who brought the project');
            $table->string('order_name',255)->nullable()->index();
            $table->string('order_no',150)->nullable()->index();
            $table->double('order_value', 28,2)->default(0)->index()->comment('project value');
            $table->text('remarks')->nullable();
            $table->boolean("is_active")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
