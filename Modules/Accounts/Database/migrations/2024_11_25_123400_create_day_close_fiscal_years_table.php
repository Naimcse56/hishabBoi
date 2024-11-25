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
        Schema::create('day_close_fiscal_years', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("fiscal_year_id")->nullable();
            $table->foreign("fiscal_year_id")->on("fiscal_years")->references("id")->onDelete("cascade");
            $table->date('from_date')->default(date("Y-m-d"))->index();
            $table->date('to_date')->nullable();
            $table->boolean("is_closed")->default(0);
            $table->unsignedBigInteger("closed_by")->nullable();
            $table->foreign("closed_by")->on("users")->references("id")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_close_years');
    }
};
