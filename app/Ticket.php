<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $filltable = ['subject', 'content', 'create_by', 'status', 'priority', 'deadline', 'assigned_to', 'rating', 'team_id', 'resolved_at', 'closed_at', 'deleted_at'];

    public $timestamps = true;

    public function ticket_read() {
    	return $this -> hasMany('App\Ticket_read');
    }

    public function ticket_relater() {
    	return $this -> hasMany('App\Ticket_relater');
    }

    public function ticket_thread() {
    	return $this -> hasMany('App\Ticket_thread');
    }

    public function ticket_image() {
    	return $this -> hasMany('App\Ticket_image');
    }

    public function team() {
        return $this -> belongsTo('App\Team');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }

}
