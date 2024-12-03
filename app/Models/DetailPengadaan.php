<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengadaan extends Model
{
    use HasFactory;

    protected $table = 'v_detail_pengadaan'; // Nama view
    public $timestamps = false;  // Karena ini adalah view, kita tidak perlu timestamps

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

    // Jika Anda ingin menggunakan relasi dengan model lain, Anda bisa menambahkan relasi seperti di model biasa
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'idbarang', 'idbarang');
    }

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class, 'idpengadaan', 'idpengadaan');
    }
}
