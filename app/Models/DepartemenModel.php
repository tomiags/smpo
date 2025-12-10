<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $table      = 'departemen';
    protected $primaryKey = 'id_departemen';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nama_departemen', 'created_by', 'created_at', 'updated_by', 'updated_at'
    ];

    protected $useTimestamps =true;
}