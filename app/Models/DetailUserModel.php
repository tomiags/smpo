<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailUserModel extends Model
{
    protected $table      = 'detail_users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 'nama_user', 'jabatan', 'jenkel', 'tgl_lahir', 'tempat_lahir',
        'no_tlp', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = false;
}