<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'view_barang';

    public $timestamps = false;
    protected $primaryKey = null;
    protected $fillable = [
        'idbarang', 'idsatuan', 'jenis', 'nama', 'status', 'harga'
    ];
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'idsatuan', 'idsatuan');
    }
}
