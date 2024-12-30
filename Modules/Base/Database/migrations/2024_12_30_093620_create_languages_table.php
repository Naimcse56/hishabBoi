<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->tinyInteger('rtl')->default('0');
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
        });
        

        DB::table('languages')->insert(array (
            0 => 
            array (
              'code' => 'bn',
              'name' => 'Bengali',
              'status' => 0,
              'rtl' => 0,
            ),
            1 => 
            array (
              'code' => 'en',
              'name' => 'English',
              'status' => 1,
              'rtl' => 0,
            ),
            2 => 
            array (
              'code' => 'hi',
              'name' => 'Hindi',
              'status' => 0,
              'rtl' => 0,
            ),
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
