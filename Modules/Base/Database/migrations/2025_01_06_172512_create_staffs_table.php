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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->default(0);
            $table->foreignId("department_id")->default(0);
            $table->foreignId("designation_id")->default(0);
            $table->string('staff_id', 20)->unique()->index()->comment('Official ID');
            $table->string('phone', 20)->nullable()->index();
            $table->string('alternate_phone', 20)->nullable();
            $table->string('present_address', 300)->nullable();
            $table->string('permanant_address', 300)->nullable();
            $table->string('nid',255)->nullable();
            $table->string('cv',255)->nullable();
            $table->date('date_of_birth')->default(date("Y-m-d"));
            $table->date('joining_date')->default(date("Y-m-d"))->index();
            $table->enum('employement_status', ['Provision', 'Permanant', 'Contractual']);
            $table->string('remarks',300)->nullable();
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
        Schema::dropIfExists('staffs');
    }
};
