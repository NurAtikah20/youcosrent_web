<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;
    protected $tables = 'jenis_barangs';
    
    public $timestamps = true;
    public $fillable = ['jenisbarang'];
  
    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_jenis', 'id');
    }
}
