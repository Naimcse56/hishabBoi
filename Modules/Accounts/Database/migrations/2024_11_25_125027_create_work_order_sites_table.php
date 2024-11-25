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
        Schema::create('work_order_sites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("work_order_id")->default(0);
            $table->string('site_name',255)->nullable()->index();
            $table->string('site_location',255)->nullable();
            $table->double('est_budget', 28,2)->default(0);
            $table->string('site_pm_name',255)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_sites');
    }
};
