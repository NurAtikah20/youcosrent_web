<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_foto extends Model
{
    use HasFactory;
    protected $tables = 'detail_fotos';
    
    public $timestamps = true;
    public $fillable = ['keterangan','foto','id_barang'];
      public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang','id');
    }
}
