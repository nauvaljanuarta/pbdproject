<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $connection = 'mysql';
    protected $table = 'view_vendor';
    protected $primaryKey = 'idvendor';
    public $timestamps = false;
    protected $fillable = [
        'nama_vendor',
        'badan_hukum',
        'status'
    ];

}
