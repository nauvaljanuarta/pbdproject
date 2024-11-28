<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{

    protected $table = 'view_satuan';


    public $timestamps = false;


    protected $primaryKey = null;


    protected $fillable = ['idsatuan', 'nama_satuan', 'status'];
}
