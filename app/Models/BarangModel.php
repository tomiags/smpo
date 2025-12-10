<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table      = 'barang';
    protected $primaryKey = 'kode_barang';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'kode_barang', 'nama_barang', 'harga_barang', 'stok_barang',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];

    protected $useTimestamps =true;
}