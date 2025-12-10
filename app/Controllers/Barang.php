<?php

namespace App\Controllers;

use App\Models\BarangModel;
use CodeIgniter\Controller;

class Barang extends Controller
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }


    public function index()
    {
        $barangs = $this->barangModel->findAll();

        return view('barang/index', [
            'barangs' => $barangs
        ]);
    }


    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'kode_barang'   => 'required',
            'nama_barang'   => 'required',
            'harga_barang'  => 'required',
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }


        /*
        |----------------------------------------------------------------------
        | INSERT DATA
        |----------------------------------------------------------------------
        */
        $this->barangModel->insert([
            'kode_barang'   => strtoupper($this->request->getPost('kode_barang')), 
            'nama_barang'   => strtoupper($this->request->getPost('nama_barang')), 
            'harga_barang'  => $this->request->getPost('harga_barang'),
            'stok_barang'   => $this->request->getPost('stok_barang'),
            'created_by'    => user_id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Barang berhasil ditambahkan',
        ]);
    }


    public function show($kode_barang)
    {
        $barang = $this->barangModel->find($kode_barang);

        if (!$barang) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($barang);
    }


    public function update($kode_barang)
    {
        $validation = \Config\Services::validation();

        // Cek data lama
        $existing = $this->barangModel->find($kode_barang);
        if (!$existing) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Data barang tidak ditemukan'
            ]);
        }

        // RULES
        $rules = [
            'nama_barang'   => 'required',
            'harga_barang'  => 'required',
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $this->barangModel->update($kode_barang, [
            'nama_barang'   => strtoupper($this->request->getPost('nama_barang')), 
            'harga_barang' => $this->request->getPost('harga_barang'),
            'updated_by'  => user_id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Barang berhasil diperbarui'
        ]);
    }



    public function delete($kode_barang)
    {
        $barang = $this->barangModel->find($kode_barang);

        if (!$barang) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'barang tidak ditemukan'
            ]);
        }

        $this->barangModel->delete($kode_barang);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}
