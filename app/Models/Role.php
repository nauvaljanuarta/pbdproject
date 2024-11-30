<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Menentukan nama table yang digunakan (view)
    protected $table = 'view_role';

    // Menonaktifkan timestamps karena data berasal dari view (biasanya view tidak memiliki kolom timestamps)
    public $timestamps = false;

    // Menentukan bahwa view ini tidak memiliki primary key
    protected $primaryKey = null;

    // Menentukan kolom yang bisa diisi secara massal
    protected $fillable = ['idrole', 'nama_role'];
}
