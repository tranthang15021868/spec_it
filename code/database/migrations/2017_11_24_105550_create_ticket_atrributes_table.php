<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketAtrributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_atrributes', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('status', 255) -> nullAble();
            $table -> string('priority', 255) -> nullAble();
            $table -> string('rating', 255) -> nullAble();
            $table -> string('reopened', 255) -> nullAble();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_atrributes');
    }
}
