<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    use HasFactory;
   
    protected $tables = 'detail_transaksis';
    
    public $timestamps = true;
  protected $guarded = ['id'];
      public function detail_barang()
    {
        return $this->belongsTo(detail_barang::class, 'id_detailbarang','id');
    }
      public function transaksi()
    {
        return $this->belongsTo(transaksi::class, 'id_transkasi','id');
    }
}
