<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $filltable = ['name'];

    public $timestamps = true;

    public function user() {
    	return $this -> hasMany('App\User');
    }

    public function ticket() {
    	return $this -> hasMany('App\Ticket');
    }
}
