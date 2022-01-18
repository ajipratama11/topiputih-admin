<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();;
            $table->string('program_name');
            $table->string('program_image');
            $table->string('company_name');
            $table->integer('price_1');
            $table->integer('price_2');
            $table->integer('price_3');
            $table->integer('price_4');
            $table->integer('price_5');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('description');
            $table->string('scope');
            $table->enum('status', ['Aktif', 'Tidak Aktif']);
            $table->enum('category', ['Publik', 'Privat']);
            $table->enum('type', ['Bug Bounty', 'Vulnerability Disclosure', 'Penetration Testing']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
