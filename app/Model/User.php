<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password', 'first_name', 'last_name', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'user_task');
    }

    public function isAdmin()
    {
        return $this->role->hasRole('admin');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function log()
    {
        return $this->hasMany(TaskLog::class, 'carried_out_by', 'id');
    }

    public function latest(){
        return $this->log()->latest()->first();
    }

    public function gists(){
        return $this->hasMany(Gists::class);
    }
}
