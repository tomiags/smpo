<?php

namespace App\Models;

use CodeIgniter\Model;

class POitemsModel extends Model
{
    protected $table      = 'po_items';
    protected $primaryKey = 'id_po_items';

    protected $allowedFields = [
        'id_po', 'kode_barang', 'qty', 'harga_satuan', 'subtotal', 'catatan'
    ];

}