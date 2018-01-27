<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'level','team_id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function team() {
        return $this -> belongsTo('App\Team');
    }

    public function ticket_read() {
        return $this -> hasMany('App\Ticket_read');
    }

    public function ticket_relater() {
        return $this -> hasMany('App\Ticket_relater');
    }

     public function ticket_thread() {
        return $this -> hasMany('App\Ticket_thread');
    }

    public function ticket_create_by() {
        return $this -> hasMany('App\Ticket', 'create_by');
    }

    public function ticket_assigned_to() {
        return $this -> hasMany('App\Ticket', 'assigned_to');
    }
}