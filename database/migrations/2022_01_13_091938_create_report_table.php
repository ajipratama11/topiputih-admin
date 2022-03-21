<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('program_id')->unsigned();
            $table->string('summary');
            $table->string('slug')->unique();
            $table->string('scope_report');
            $table->bigInteger('category_id')->unsigned();
            $table->text('description_report');
            $table->string('impact');
            $table->string('file')->nullable();
            $table->date('date')->nullable();
            $table->string('status_report')->nullable();
            $table->string('status_causes')->nullable();
            $table->decimal('point',8,2)->nullable();
            $table->integer('reward')->nullable();
            $table->string('status_reward')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category_reports')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
