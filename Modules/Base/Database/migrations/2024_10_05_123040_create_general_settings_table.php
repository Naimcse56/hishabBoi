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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('general_settings')->insert(array(
            0 => array(
               'name' => 'company_name',
               'value' => 'Hishab Boi',
            ),
            1 => array(
               'name' => 'company_logo',
               'value' => 'assets/images/invoice.png',
            ),
            2 => array(
               'name' => 'company_address',
               'value' => null,
            ),
            3 => array(
               'name' => 'company_phone',
               'value' => '01873844448',
            ),
            4 => array(
               'name' => 'company_email',
               'value' => 'admin@example.com',
            ),
            5 => array(
               'name' => 'favicon',
               'value' => null,
            ),
            6 => array(
               'name' => 'system_currency_symbol',
               'value' => 'TK',
            ),
            7 => array(
               'name' => 'system_currency_id',
               'value' => 0,
            ),
            8 => array(
               'name' => 'date_format',
               'value' => 'd/m/Y',
            ),
            9 => array(
               'name' => 'decimal_point',
               'value' => 2,
            ),
            10 => array(
               'name' => 'currency_position',
               'value' => 'left',
            ),
            11 => array(
               'name' => 'purchase_terms_condition',
               'value' => null,
            ),
            12 => array(
               'name' => 'sale_terms_condition',
               'value' => null,
            ),
        ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
