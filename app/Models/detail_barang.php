<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_barang extends Model
{
    use HasFactory;
    protected $tables = 'detail_barangs';
    
    public $timestamps = true;
    public $fillable = ['ukuran','warna','stok','id_barang'];
      public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang','id');
    }
    public function detailtransaksi()
    {
        return $this->hasMany(detail_transaksi::class, 'id_detailbarang', 'id');
    }
}
