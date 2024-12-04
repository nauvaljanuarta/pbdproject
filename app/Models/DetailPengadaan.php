<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengadaan extends Model
{
    use HasFactory;

    protected $table = 'view_detail_pengadaan';
    protected $primaryKey = 'iddetail_pengadaan';
    public $timestamps = false;
    protected $fillable = [
        'iddetail_pengadaan',
        'harga_satuan',
        'jumlah',
        'sub_total',
        'idbarang',
        'nama_barang',
        'idpengadaan',
        'pengadaan_timestamp',
        'pengadaan_status',
        'subtotal_nilai',
        'ppn',
        'total_nilai'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'idbarang', 'idbarang');
    }

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'id_pengadaan', 'id_pengadaan');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}
