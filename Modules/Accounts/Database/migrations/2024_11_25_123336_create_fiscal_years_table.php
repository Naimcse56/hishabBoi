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
        Schema::create('fiscal_years', function (Blueprint $table) {
            $table->id();
            $table->date('from_date')->default(date("Y-m-d"))->index();
            $table->date('to_date')->nullable();
            $table->string('year',10)->nullable()->comment("ex: 23-24");
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
        Schema::dropIfExists('fiscal_years');
    }
};
