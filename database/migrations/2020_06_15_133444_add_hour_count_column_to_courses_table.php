<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHourCountColumnToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->smallInteger('hour_count')->nullable();
            $table->unsignedBigInteger("course_type_id");
            $table->smallInteger('course_modality_id')->nullable();

            $table->foreign("course_type_id")->references("id")->on("course_types");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->removeColumn("hour_count");
            $table->removeColumn("course_type_id");
            $table->removeColumn('course_modality_id');
        });
    }
}
