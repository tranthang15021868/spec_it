<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_relater extends Model
{
    protected $table = 'ticket_relaters';

    protected $filltable = ['ticket_id', 'employee_id'];

    public $timestamps = true;

    public function ticket() {
    	return $this -> belongsTo('App\Ticket');
    }

    public function user() {
    	return $this -> belongsTo('App\User');
    }
}
