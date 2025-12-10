<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table      = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $allowedFields = [
        'id_po', 'tgl_transaksi', 'total_tagihan', 'status_bayar',
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

}