<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('classes_id');
            $table->string('course_code');
            $table->string('name');
            $table->integer('total_hours')->default(0);
            $table->integer('total_practicals')->default(0);
            $table->integer('total_tutorials')->default(0);
            $table->integer('total_assignments')->default(0);
            $table->timestamps();
            $table->softDeletes();  
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->tinyinteger('status')->default(1);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('classes_id')->references('id')->on('classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
