<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_read extends Model
{
    protected $table = 'ticket_reads';

    protected $filltable = ['reader_id', 'ticket_id','status'];

    public $timestamps = true;

    public function ticket() {
    	return $this -> belongsTo('App\Ticket');
    }

    public function user() {
    	return $this -> belongsTo('App\User');
    }
}
