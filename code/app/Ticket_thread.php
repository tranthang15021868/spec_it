<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_thread extends Model
{
    protected $table = 'ticket_threads';

    protected $filltable = ['ticket_id', 'employee_id', 'content', 'type', 'note'];

    public $timestamps = true;

    public function ticket() {
    	return $this -> belongsTo('App\Ticket');
    }

    public function user() {
    	return $this -> belongsTo('App\User');
    }
}
