<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRetur extends Model
{
    protected $table = 'view_detail_returr';

    protected $primaryKey = 'iddetail_retur';
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'idbarang', 'idsatuan');
    }
}
