<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
   
    protected $tables = 'transaksis';
    
    public $timestamps = true;
  protected $guarded = ['id'];
      public function pelanggan()
    {
        return $this->belongsTo(pelanggan::class, 'id_pelanggan','id');
    }
    public function detailtransaksi()
    {
        return $this->hasMany(detail_transaksi::class, 'id_detailbarang', 'id');
    }
}
