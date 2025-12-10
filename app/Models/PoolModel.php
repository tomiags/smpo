<?php

namespace App\Models;

use CodeIgniter\Model;

class PoolModel extends Model
{
    protected $table      = 'pool';
    protected $primaryKey = 'kode_pool';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'kode_pool', 'nama_pool', 'lokasi_pool', 'kota_pool', 'prov_pool',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];

    protected $useTimestamps =true;
}