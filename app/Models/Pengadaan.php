<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    // Nama tabel (view)
    protected $table = 'view_pengadaan';

    protected $primaryKey = 'id_pengadaan';

    public $timestamps = false;

    protected $fillable = [
        'id_pengadaan',
        'waktu_pengadaan',
        'nama_user',
        'nama_vendor',
        'status_pengadaan',
        'subtotal',
        'nilai_ppn',
        'total',
        'id_detail',
        'nama_barang',
        'harga_satuan',
        'jumlah',
        'subtotal_barang',
    ];

        public function user()
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_idvendor');
    }

    public function details()
    {
        return $this->hasMany(DetailPengadaan::class, 'iddetail_pengadaan');
    }

}
