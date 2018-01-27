<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_image extends Model
{
    protected $table = 'ticket_images';

    protected $filltable = ['url_image'];

    public $timestamps = true;

    public function ticket() {
    	return $this -> belongsTo('App\Ticket');
    }
}
