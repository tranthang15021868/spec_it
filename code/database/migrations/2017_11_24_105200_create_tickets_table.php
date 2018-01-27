<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('subject',255);
            $table->text('content');
            $table->integer('create_by')->unsigned();
            $table->foreign('create_by')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('status');
            $table->tinyInteger('priority');
            $table->dateTime('deadline');
            $table->integer('assigned_to')->unsigned()->nullAble();
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table -> tinyInteger('rating') -> nullAble();
            $table->integer('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->dateTime('resolved_at')->nullAble();
            $table->dateTime('closed_at')->nullAble();
            $table->dateTime('deleted_at')->nullAble();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
