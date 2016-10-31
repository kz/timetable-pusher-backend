<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimetablesTableWithHasPeriodNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->boolean('has_period_numbers')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropColumn('has_period_numbers');
        });
    }
}
