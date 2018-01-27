<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table -> integer('employee_id') -> unsigned();
            $table -> foreign('employee_id') -> references('id') -> on('users') -> onDelete('cascade');
            $table -> text('content');
            $table -> tinyInteger('type') -> nullAble();
            $table -> string('note', 255) -> nullAble();
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
        Schema::dropIfExists('ticket_threads');
    }
}
