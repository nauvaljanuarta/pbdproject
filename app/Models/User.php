<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'view_user';
    public $timestamps = false;
    protected $primaryKey = 'iduser';
    protected $fillable = ['iduser', 'username', 'password', 'idrole'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }
}
