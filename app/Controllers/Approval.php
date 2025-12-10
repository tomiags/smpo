<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\ApprovalPoModel;
use App\Models\POitemsModel;

class Approval extends BaseController
{
    public function request()
    {
        $poModel = new PurchaseOrderModel();

        $data['po'] = $poModel
            ->select('purchase_order.*, supplier.nama_supplier, departemen.nama_departemen, pool.nama_pool')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier', 'left')
            ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen', 'left')
            ->join('pool', 'pool.kode_pool = purchase_order.kode_pool', 'left')
            ->where('status_po', 'send')
            ->orderBy('id_po', 'DESC')
            ->findAll();

        return view('approval/request_approval', $data);
    }

    public function detail($id)
    {
        $poModel   = new PurchaseOrderModel();
        $itemModel = new POitemsModel();


        $data['po'] = $poModel
            ->select('purchase_order.*, 
                    supplier.nama_supplier, 
                    departemen.nama_departemen, 
                    pool.nama_pool,
                    detail_users.nama_user')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier')
            ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen')
            ->join('pool', 'pool.kode_pool = purchase_order.kode_pool')

            ->join('users', 'users.id = purchase_order.id_user')
            ->join('detail_users', 'detail_users.user_id = users.id')

            ->where('purchase_order.id_po', $id)
            ->first();

        $data['items'] = $itemModel
            ->select('po_items.*, barang.nama_barang')
            ->join('barang', 'barang.kode_barang = po_items.kode_barang')
            ->where('id_po', $id)
            ->findAll();

        return view('approval/modal_detail_approval', $data);
    }

    public function approve()
    {
        $id_po = $this->request->getPost('id_po');
        $catatan = $this->request->getPost('catatan');

        $approvalModel = new ApprovalPoModel();
        $poModel = new PurchaseOrderModel();

        // Simpan approval
        $approvalModel->insert([
            'id_po'       => $id_po,
            'status'      => 'approve',
            'catatan'     => 'Disetujui',
            'created_by' => user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Update PO
        $poModel->update($id_po, [
            'status_po' => 'approve',
            'updated_by' => user()->id
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'PO berhasil di-approve'
        ]);
    }

    public function reject()
    {
        $id_po = $this->request->getPost('id_po');
        $catatan = $this->request->getPost('catatan');

        $approvalModel = new ApprovalPoModel();
        $poModel = new PurchaseOrderModel();

        // Simpan reject log
        $approvalModel->insert([
            'id_po'       => $id_po,
            'status'      => 'reject',
            'catatan'     => $catatan,
            'created_by' => user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Update PO
        $poModel->update($id_po, [
            'status_po' => 'reject',
            'updated_by' => user()->id
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'PO ditolak'
        ]);
    }
}
