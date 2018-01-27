<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketReadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_reads', function (Blueprint $table) {
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->integer('reader_id')->unsigned();
            $table->foreign('reader_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('ticket_reads');
    }
}
