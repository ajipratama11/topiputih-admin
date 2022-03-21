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
            $table->string('slug')->unique();
            $table->string('program_image')->nullable();
            $table->string('company_name')->nullable();
            $table->integer('price_1')->nullable();
            $table->integer('price_2')->nullable();
            $table->integer('price_3')->nullable();
            $table->integer('price_4')->nullable();
            $table->integer('price_5')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->text('description');
            $table->text('scope');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->nullable();
            $table->enum('category', ['Publik', 'Privat'])->nullable();
            $table->enum('type', ['Bug Bounty', 'Vulnerability Disclosure', 'Penetration Testing'])->nullable();
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
