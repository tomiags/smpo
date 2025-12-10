<?php

namespace App\Controllers;

use App\Models\PurchaseOrderModel;
use App\Models\POitemsModel;
use App\Models\TransaksiModel;
use App\Models\ApprovalPoModel;
use App\Models\PembayaranModel;

class Transaksi extends BaseController
{
    public function create()
    {
        return view('transaksi/transaksi_baru');
    }

    public function searchPO()
    {
        $poModel = new PurchaseOrderModel();

        $data['po'] = $poModel
            ->select('purchase_order.*, supplier.nama_supplier, detail_users.nama_user, departemen.nama_departemen')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier')
            ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen')
            ->join('users', 'users.id = purchase_order.id_user')
            ->join('detail_users', 'detail_users.user_id = users.id')
            ->join('transaksi', 'transaksi.id_po = purchase_order.id_po AND transaksi.deleted_at IS NULL', 'left')
            ->where('purchase_order.status_po', 'approve')
            ->where('transaksi.id_po', null)
            ->findAll();

        return view('transaksi/search_po_modal', $data);
    }


    public function getPO($id)
    {
        $poModel   = new PurchaseOrderModel();
        $itemModel = new POitemsModel();
        $approvalModel = new ApprovalPoModel();

        // Ambil PO
        $po = $poModel
            ->select('purchase_order.*, supplier.nama_supplier, detail_users.nama_user, departemen.nama_departemen')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier')
            ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen')
            ->join('users', 'users.id = purchase_order.id_user')
            ->join('detail_users', 'detail_users.user_id = users.id')
            ->where('purchase_order.id_po', $id)
            ->first();

        // Ambil approval yang menyetujui PO ini
        $approval = $approvalModel
            ->select('approval_po.*, detail_users.nama_user AS disetujui_oleh')
            ->join('users', 'users.id = approval_po.created_by')
            ->join('detail_users', 'detail_users.user_id = users.id')
            ->where('approval_po.id_po', $id)
            ->where('approval_po.status', 'approve')
            ->first();

        // Ambil item
        $items = $itemModel
            ->select('po_items.*, barang.nama_barang')
            ->join('barang', 'barang.kode_barang = po_items.kode_barang')
            ->where('id_po', $id)
            ->findAll();

        return $this->response->setJSON([
            'po'       => $po,
            'items'    => $items,
            'approval' => $approval
        ]);
    }

    public function store()
    {
        $transModel = new TransaksiModel();
        $bayarModel = new PembayaranModel();

        $id_po         = $this->request->getPost('id_po');
        $total_tagihan = floatval($this->request->getPost('total_tagihan'));
        $jumlah_bayar  = floatval($this->request->getPost('jumlah_bayar'));
        $metode        = $this->request->getPost('metode');
        $catatan       = $this->request->getPost('catatan');

        // Tentukan status bayar
        $status = ($jumlah_bayar >= $total_tagihan) ? 'lunas' : 'belum';

        // Simpan Transaksi
        $transData = [
            'id_po'         => $id_po,
            'tgl_transaksi' => date('Y-m-d'),
            'total_tagihan' => $total_tagihan,
            'status_bayar'  => $status,
            'created_by'    => user()->id,
        ];

        $transModel->save($transData);

        // Ambil ID transaksi yang baru diinsert
        $id_transaksi = $transModel->getInsertID();

        // Simpan Pembayaran Pertama
        if ($jumlah_bayar > 0) {
            $bayarModel->save([
                'id_transaksi' => $id_transaksi,
                'tgl_bayar'    => date('Y-m-d'),
                'metode'       => $metode,
                'jumlah_bayar' => $jumlah_bayar,
                'catatan'      => $catatan,
                'created_by'   => user()->id,
            ]);
        }

        // Redirect
        return redirect()->to('/transaksi/list')->with('success', 'Transaksi & pembayaran berhasil disimpan');
    }

    public function list()
    {
        $transModel = new TransaksiModel();

        $data['transaksi'] = $transModel
            ->select('transaksi.*, purchase_order.no_po, purchase_order.tgl_po, supplier.nama_supplier, detail_users.nama_user, departemen.nama_departemen')
            ->join('purchase_order', 'purchase_order.id_po = transaksi.id_po')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier')
            ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen')
            ->join('users', 'users.id = purchase_order.id_user')
            ->join('detail_users', 'detail_users.user_id = users.id')
            ->orderBy('transaksi.id_transaksi', 'DESC')
            ->findAll();

        return view('transaksi/list_transaksi', $data);
    }

    public function detail($id)
    {
        $transModel = new TransaksiModel();
        $bayarModel = new PembayaranModel();
        $poModel = new PurchaseOrderModel();
        $itemModel = new POitemsModel();

        // Ambil transaksi lengkap
        $transaksi = $transModel
            ->select('transaksi.*, purchase_order.no_po, purchase_order.tgl_po, supplier.nama_supplier,
                    detail_users.nama_user, departemen.nama_departemen')
            ->join('purchase_order', 'purchase_order.id_po = transaksi.id_po')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier')
            ->join('departemen', 'departemen.id_departemen = purchase_order.id_departemen')
            ->join('users', 'users.id = purchase_order.id_user')
            ->join('detail_users', 'detail_users.user_id = users.id')
            ->where('transaksi.id_transaksi', $id)
            ->first();

        // Pembayaran
        $pembayaran = $bayarModel
            ->where('id_transaksi', $id)
            ->orderBy('id_bayar', 'ASC')
            ->findAll();

        // Item PO
        $items = $itemModel
            ->select('po_items.*, barang.nama_barang, barang.harga_barang')
            ->join('barang', 'barang.kode_barang = po_items.kode_barang')
            ->where('po_items.id_po', $transaksi['id_po'])
            ->findAll();

        return view('transaksi/modal_detail_transaksi', [
            'transaksi' => $transaksi,
            'items'     => $items,
            'pembayaran'=> $pembayaran,
        ]);
    }

    public function delete($id)
    {
        $transModel = new TransaksiModel();
        $bayarModel = new PembayaranModel();

        // Cek apakah transaksi ada
        $trans = $transModel->find($id);

        if (!$trans) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }

        // Hapus seluruh pembayaran terkait transaksi
        $bayarModel->where('id_transaksi', $id)->delete();

        // Hapus transaksi
        $transModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }

    public function formBayar($id)
    {
        $trans = new TransaksiModel();
        $bayar = new PembayaranModel();

        $data = $trans
            ->select('transaksi.*, purchase_order.no_po, supplier.nama_supplier')
            ->join('purchase_order', 'purchase_order.id_po = transaksi.id_po')
            ->join('supplier', 'supplier.id_supplier = purchase_order.id_supplier')
            ->where('id_transaksi', $id)
            ->first();

        $total_bayar = $bayar
            ->where('id_transaksi', $id)
            ->selectSum('jumlah_bayar')
            ->first()['jumlah_bayar'] ?? 0;

        $data['total_bayar'] = $total_bayar;
        $data['kekurangan']  = $data['total_tagihan'] - $total_bayar;

        return view('transaksi/form_bayar', $data);
    }


    public function simpanBayar()
    {
        $bayar = new PembayaranModel();
        $trans = new TransaksiModel();

        $id = $this->request->getPost('id_transaksi');
        $metode = $this->request->getPost('metode');
        $jumlah = floatval($this->request->getPost('jumlah_bayar'));
        $catatan = $this->request->getPost('catatan');
        $kekurangan = floatval($this->request->getPost('kekurangan'));

        $bayar->save([
            'id_transaksi' => $id,
            'tgl_bayar'    => date('Y-m-d'),
            'metode'       => $metode,
            'jumlah_bayar' => $jumlah,
            'catatan'      => $catatan,
            'created_by'   => user()->id
        ]);


        if ($jumlah >= $kekurangan) {
            $trans->update($id, ['status_bayar' => 'lunas']);
        }

        return redirect()->back()->with('success','Pembayaran berhasil ditambahkan');
    }

   public function listBayar()
    {
        $bayarModel = new PembayaranModel();

        $data['pembayaran'] = $bayarModel
            ->select('pembayaran.*, transaksi.id_po, transaksi.total_tagihan, detail_users.nama_user, purchase_order.no_po')
            ->join('transaksi', 'transaksi.id_transaksi = pembayaran.id_transaksi AND transaksi.deleted_at IS NULL')
            ->join('purchase_order', 'purchase_order.id_po = transaksi.id_po')
            ->join('users', 'users.id = transaksi.created_by')
            ->join('detail_users', 'detail_users.user_id = users.id')
            ->where('pembayaran.deleted_at', null)
            ->orderBy('pembayaran.id_bayar', 'DESC')
            ->findAll();

        return view('transaksi/list_bayar', $data);
    }

    public function detailBayar($id)
    {
        $bayarModel = new PembayaranModel();

        $bayar = $bayarModel
                    ->select('pembayaran.*, transaksi.total_tagihan, detail_users.nama_user, purchase_order.no_po')
                    ->join('transaksi', 'transaksi.id_transaksi = pembayaran.id_transaksi')
                    ->join('purchase_order', 'purchase_order.id_po = transaksi.id_po')
                    ->join('users', 'users.id = pembayaran.created_by')
                    ->join('detail_users', 'detail_users.user_id = users.id')
                    ->where('pembayaran.id_bayar', $id)
                    ->first();

        return view('transaksi/modal_detail_bayar', ['bayar' => $bayar]);
    }


    public function editBayar($id)
    {
        $bayarModel = new PembayaranModel();

        // Ambil data bayar lengkap dengan join tabel lain
        $bayar = $bayarModel
                    ->select('pembayaran.*, transaksi.total_tagihan, detail_users.nama_user, purchase_order.no_po')
                    ->join('transaksi', 'transaksi.id_transaksi = pembayaran.id_transaksi')
                    ->join('purchase_order', 'purchase_order.id_po = transaksi.id_po')
                    ->join('users', 'users.id = pembayaran.created_by')
                    ->join('detail_users', 'detail_users.user_id = users.id')
                    ->where('pembayaran.id_bayar', $id)
                    ->first();

        return view('transaksi/modal_edit_bayar', ['bayar' => $bayar]);
    }


    public function updateBayar($id)
    {
        $bayarModel = new PembayaranModel();

        $metode  = $this->request->getPost('metode');
        $catatan = $this->request->getPost('catatan');

        $bayarModel->update($id, [
            'metode'  => $metode,
            'catatan' => $catatan
        ]);

        return redirect()->to(base_url('transaksi/list_bayar'))
                        ->with('success', 'Pembayaran berhasil diupdate');
    }


    public function deleteBayar($id)
    {
        $bayarModel = new PembayaranModel();
        $transaksiModel = new TransaksiModel();

        $bayar = $bayarModel->find($id);

        if (!$bayar) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data pembayaran tidak ditemukan'
            ]);
        }

        $bayarModel->delete($id);

        $transaksiModel->update($bayar['id_transaksi'], [
            'status_bayar' => 'belum'
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Pembayaran berhasil dihapus'
        ]);
    }



}
