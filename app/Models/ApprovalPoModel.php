<?php

namespace App\Models;

use CodeIgniter\Model;

class ApprovalPoModel extends Model
{
    protected $table      = 'approval_po';
    protected $primaryKey = 'id_approval';

    protected $allowedFields = [
        'id_po', 'status', 'catatan', 'created_by', 'created_at'
    ];

}