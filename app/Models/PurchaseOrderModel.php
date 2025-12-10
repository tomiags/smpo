<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseOrderModel extends Model
{
    protected $table      = 'purchase_order';
    protected $primaryKey = 'id_po';

    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'no_po', 'id_user', 'id_supplier', 'id_departemen', 'kode_pool', 'tgl_po', 'status_po',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];

    protected $useTimestamps =true;
}