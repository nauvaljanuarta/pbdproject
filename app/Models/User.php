<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'view_user';
    public $timestamps = false;
    protected $primaryKey = 'iduser';
    protected $fillable = ['iduser', 'username', 'password', 'idrole'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }


}
