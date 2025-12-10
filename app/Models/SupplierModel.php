<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table      = 'supplier';
    protected $primaryKey = 'id_supplier';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nama_supplier', 'no_tlp', 'email', 'alamat_supplier',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];

    protected $useTimestamps =true;
}