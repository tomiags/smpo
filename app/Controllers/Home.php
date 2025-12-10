<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\TransaksiModel;

class Home extends BaseController
{
    public function index(): string
    {
        $poModel  = new PurchaseOrderModel();
        $trxModel = new TransaksiModel();

        $last30 = date('Y-m-d', strtotime('-30 days'));

        $poReject30 = $poModel
            ->where('status_po', 'reject')
            ->where('tgl_po >=', $last30)
            ->countAllResults();

        $poApprove30 = $poModel
            ->where('status_po', 'approve')
            ->where('tgl_po >=', $last30)
            ->countAllResults();

        $po30 = $poModel
            ->where('tgl_po >=', $last30)
            ->countAllResults();

        $trx30 = $trxModel
            ->where('tgl_transaksi >=', $last30)
            ->countAllResults();

        $data = [
            'poReject30' => $poReject30,
            'poApprove30'=> $poApprove30,
            'po30'       => $po30,
            'trx30'      => $trx30,
        ];

        return view('home/index', $data);
    }
}
