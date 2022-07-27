<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTakenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics_taken', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lecture_id');
            $table->unsignedInteger('topic_id');
            $table->integer('students_present');
            $table->timestamps();
            $table->softDeletes();  
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->tinyinteger('status')->default(1);

            $table->foreign('lecture_id')->references('id')->on('lectures');
            $table->foreign('topic_id')->references('id')->on('topics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics_taken');
    }
}
