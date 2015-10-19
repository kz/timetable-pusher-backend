<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', [
                'created',
                'in_progress',
                'failed'
            ]);
            $table->integer('timetable_id')->unsigned();
            $table->foreign('timetable_id')->references('id')->on('timetables');
            $table->timestamps();
            $table->dateTime('ended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }
}
