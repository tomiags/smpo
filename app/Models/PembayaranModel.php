<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table      = 'pembayaran';
    protected $primaryKey = 'id_bayar';

    protected $allowedFields = [
        'id_transaksi', 'tgl_bayar', 'metode', 'jumlah_bayar', 'catatan', 
        'created_by', 'created_at', 'updated_by', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

}