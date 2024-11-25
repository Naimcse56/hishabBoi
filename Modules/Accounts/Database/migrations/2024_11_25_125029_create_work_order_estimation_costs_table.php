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
        Schema::create('work_order_estimation_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("work_order_id")->default(0);
            $table->unsignedBigInteger("ledger_id")->default(0);
            $table->double('estimated_amount', 28,2)->default(0);
            $table->double('actual_cost', 28,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_estimation_costs');
    }
};
