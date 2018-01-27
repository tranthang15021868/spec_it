<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket_atrribute extends Model
{
    protected $table = 'ticket_atrributes';

    protected $filltable = ['status', 'priority', 'rating', 'reopened'];

    public $timestamps = true;
}
