<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('month_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('month_id');
            $table->integer('lectures_planned');
            $table->integer('practicals_planned');
            $table->timestamps();
            $table->softDeletes();  
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('month_id')->references('id')->on('months');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('month_subject');
    }
}
