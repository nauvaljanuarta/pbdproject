<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    // Nama tabel (view)
    protected $table = 'view_pengadaan';

    protected $primaryKey = null;

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'id_pengadaan',
        'waktu_pengadaan',
        'nama_user',
        'nama_vendor',
        'status_pengadaan',
        'subtotal',
        'ppn',
        'total',
        'id_detail',
        'nama_barang',
        'harga_satuan',
        'jumlah',
        'subtotal_barang',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_idvendor', 'idvendor');
    }

    public function details()
    {
        return $this->hasMany(DetailPengadaan::class, 'idpengadaan', 'idpengadaan');
    }
}
