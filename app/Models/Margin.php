<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Margin extends Model
{
    protected $table = 'view_margin_penjualan';

    // Karena ini adalah view, kita nonaktifkan timestamps
    public $timestamps = false;
    protected $primaryKey = 'idmargin_penjualan';

    // Tentukan kolom yang bisa diakses secara mass-assignment
    protected $fillable = [
        'idmargin_penjualan',
        'iduser',
        'user_name',
        'persen',
        'status',
        'created_at',
        'updated_at',
    ];

    // Jika diperlukan, tambahkan relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}
