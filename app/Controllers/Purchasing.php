<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\POitemsModel;
use App\Models\SupplierModel;
use App\Models\DepartemenModel;
use App\Models\PoolModel;
use App\Models\BarangModel;

use Dompdf\Dompdf;

class Purchasing extends BaseController
{
    public function request_po()
    {
        $data = [
            'suppliers'   => model('SupplierModel')->findAll(),
            'departemen'  => model('DepartemenModel')->findAll(),
            'pool'        => model('PoolModel')->findAll(),
            'barang'      => model('BarangModel')->findAll(), 
        ];

        return view('purchasing/request_po', $data);
    }


    public function save_po()
    {
        $poModel      = new \App\Models\PurchaseOrderModel();
        $poItemsModel = new \App\Models\POitemsModel();

        $id_supplier   = $this->request->getPost('id_supplier');
        $id_departemen = $this->request->getPost('id_departemen');
        $kode_pool     = $this->request->getPost('kode_pool');
        $tgl_po        = $this->request->getPost('tgl_po');

        $user_id       = user()->id;

        $dataPO = [
            'no_po'        => null,
            'id_user'      => $user_id,
            'id_supplier'  => $id_supplier,
            'id_departemen'=> $id_departemen,
            'kode_pool'    => $kode_pool,
            'tgl_po'       => $tgl_po,
            'status_po'    => 'Draft',
            'created_by'   => $user_id,
        ];

        $poModel->insert($dataPO);

        $id_po = $poModel->insertID();

        // Generate nomor PO
        $no_po = 'BST-PO-' . str_pad($id_po, 5, '0', STR_PAD_LEFT);

        // Update nomor PO
        $poModel->update($id_po, ['no_po' => $no_po]);

        // ===========================
        // INSERT ITEMS
        // ===========================

        $kode_barang = $this->request->getPost('kode_barang');
        $qty         = $this->request->getPost('qty');
        $harga       = $this->request->getPost('harga');
        $catatan     = $this->request->getPost('catatan_barang');

        if (!empty($kode_barang)) {
            foreach ($kode_barang as $i => $kode) {

                $qty_val   = (int)$qty[$i];
                $harga_val = (int)$harga[$i];
                $subtotal  = $qty_val * $harga_val;

                $poItemsModel->insert([
                    'id_po'        => $id_po,
                    'kode_barang'  => $kode,
                    'qty'          => $qty_val,
                    'harga_satuan' => $harga_val,
                    'subtotal'     => $subtotal,
                    'catatan'      => $catatan[$i] ?? null
                ]);
            }
        }

        return redirect()->to('/purchasing/po_list')->with('success', 'PO berhasil dibuat dengan Nomor: ' . $no_po);
    }

    public function po_list()
    {
        $po = model('PurchaseOrderModel')
                ->select('purchase_order.*, supplier.nama_supplier, departemen.nama_departemen, pool.nama_pool')
                ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier', 'left')
                ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen', 'left')
                ->join('pool', 'pool.kode_pool = purchase_order.kode_pool', 'left')
                ->orderBy('id_po', 'DESC')
                ->findAll();

        return view('purchasing/list_po', ['po' => $po]);
    }

    public function po_detail($id)
    {
        $poModel   = new \App\Models\PurchaseOrderModel();
        $itemModel = new \App\Models\POitemsModel();

        $data['po'] = $po = $poModel
            ->select('purchase_order.*, supplier.nama_supplier, departemen.nama_departemen, pool.nama_pool')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier')
            ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen')
            ->join('pool', 'pool.kode_pool = purchase_order.kode_pool')
            ->where('id_po', $id)->first();

        $data['items'] = $itemModel
            ->select('po_items.*, barang.nama_barang')
            ->join('barang', 'barang.kode_barang = po_items.kode_barang')
            ->where('id_po', $id)->findAll();

        return view('purchasing/modal_detail_po', $data);
    }

    public function po_edit($id)
    {
        $poModel = new PurchaseOrderModel();
        $detailModel = new PoItemsModel();
        $supplier = new SupplierModel();
        $departemen = new DepartemenModel();
        $pool = new PoolModel();
        $barang = new BarangModel();

        $data = [
            'po'        => $poModel->find($id),
            'detail'    => $detailModel
                            ->select('po_items.*, barang.nama_barang, barang.harga_barang')
                            ->join('barang', 'barang.kode_barang = po_items.kode_barang')
                            ->where('id_po',$id)
                            ->findAll(),
            'suppliers' => $supplier->findAll(),
            'departemen'=> $departemen->findAll(),
            'pool'      => $pool->findAll(),
            'barang'    => $barang->findAll()
        ];

        return view('purchasing/edit_po', $data);
    }

    public function update_po($id)
    {
        $poModel = new PurchaseOrderModel();
        $detailModel = new PoItemsModel();

        $poModel->update($id, [
            'id_supplier'   => $this->request->getPost('id_supplier'),
            'id_departemen' => $this->request->getPost('id_departemen'),
            'kode_pool'     => $this->request->getPost('kode_pool'),
            'updated_by'    => user()->id,
        ]);

        $detailModel->where('id_po', $id)->delete();

        $kode_barang = $this->request->getPost('kode_barang');
        $harga       = $this->request->getPost('harga');
        $qty         = $this->request->getPost('qty');
        $catatan     = $this->request->getPost('catatan_barang');

        if (!empty($kode_barang)) {
            foreach ($kode_barang as $i => $kode) {

                $qty_val   = (int)$qty[$i];
                $harga_val = (int)$harga[$i];
                $subtotal  = $qty_val * $harga_val;

                $detailModel->insert([
                    'id_po'         => $id,
                    'kode_barang'   => $kode,
                    'qty'           => $qty_val,
                    'harga_satuan'  => $harga_val, 
                    'subtotal'      => $subtotal,   
                    'catatan'       => $catatan[$i] ?? null
                ]);
            }
        }

        return redirect()->to('/purchasing/po_list')->with('msg','PO berhasil diperbarui');
    }

    public function delete_po($id)
    {
        $detailModel = new PoItemsModel();
        $poModel     = new PurchaseOrderModel();

        $detailModel->where('id_po', $id)->delete();

        $poModel->delete($id, true);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'PO berhasil dihapus'
        ]);
    }

    public function send_po($id)
    {
        $poModel = new PurchaseOrderModel();

        // Update status menjadi "send"
        $poModel->update($id, [
            'status_po' => 'send',
            'updated_by' => user()->id,
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'PO berhasil dikirim!'
        ]);
    }


    public function po_print($id)
    {
        $poModel   = new PurchaseOrderModel();
        $itemModel = new POitemsModel();

        $po = $poModel
            ->select('purchase_order.*, supplier.nama_supplier, departemen.nama_departemen, pool.nama_pool,
                    detail_users.nama_user AS dibuat_oleh,
                    approver.nama_user AS disetujui_oleh')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier')
            ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen')
            ->join('pool', 'pool.kode_pool = purchase_order.kode_pool')

            // user yang membuat PO
            ->join('detail_users', 'detail_users.user_id = purchase_order.created_by', 'left')

            // user yang menyetujui PO
            ->join('approval_po', 'approval_po.id_po = purchase_order.id_po', 'left')
            ->join('detail_users approver', 'approver.user_id = approval_po.created_by', 'left')

            ->where('purchase_order.id_po', $id)
            ->first();


        if (!$po) {
            return redirect()->back()->with('error', 'PO tidak ditemukan');
        }

        $items = $itemModel
            ->select('po_items.*, barang.nama_barang')
            ->join('barang', 'barang.kode_barang = po_items.kode_barang')
            ->where('id_po', $id)
            ->findAll();

        $html = view('purchasing/pdf_po', [
            'po' => $po,
            'items' => $items
        ]);

        // Generate PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('Purchase Order-'.$po['no_po'].'.pdf', ['Attachment' => 0]);
    }


}
