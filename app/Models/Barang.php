<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    // use HasFactory;
    protected $tables = 'barangs';
    
    public $timestamps = true;
    public $fillable = ['id_jenis','nama_barang','deskripsi'];
      public function jenisbarang()
    {
        return $this->belongsTo(JenisBarang::class, 'id_jenis','id');
    }
    public function detailbarang()
    {
        return $this->hasMany(detail_barang::class, 'id_barang', 'id');
    }
    public function detailfoto()
    {
        return $this->hasMany(detail_foto::class, 'id_barang', 'id');
    }
}
