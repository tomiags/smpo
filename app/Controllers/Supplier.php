<?php

namespace App\Controllers;

use App\Models\SupplierModel;
use CodeIgniter\Controller;

class Supplier extends Controller
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }


    public function index()
    {
        $suppliers = $this->supplierModel->findAll();

        return view('supplier/index', [
            'suppliers' => $suppliers
        ]);
    }


    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_supplier'   => 'required',
            'no_tlp'          => 'required',
            'email'           => 'required|valid_email',
            'alamat_supplier' => 'required',
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $this->supplierModel->insert([
            'nama_supplier'   => strtoupper($this->request->getPost('nama_supplier')),
            'no_tlp'          => $this->request->getPost('no_tlp'),
            'email'           => $this->request->getPost('email'),
            'alamat_supplier' => $this->request->getPost('alamat_supplier'),
            'created_by'      => user_id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Supplier berhasil ditambahkan'
        ]);
    }


    public function show($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Supplier tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($supplier);
    }


    public function update($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Supplier tidak ditemukan'
            ]);
        }

        $validation = \Config\Services::validation();

        $rules = [
            'nama_supplier'   => 'required',
            'no_tlp'          => 'required',
            'email'           => 'required|valid_email',
            'alamat_supplier' => 'required',
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $this->supplierModel->update($id, [
            'nama_supplier'   => strtoupper($this->request->getPost('nama_supplier')),
            'no_tlp'          => $this->request->getPost('no_tlp'),
            'email'           => $this->request->getPost('email'),
            'alamat_supplier' => $this->request->getPost('alamat_supplier'),
            'updated_by'      => user_id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Supplier berhasil diperbarui'
        ]);
    }


    public function delete($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Supplier tidak ditemukan'
            ]);
        }

        $this->supplierModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Supplier berhasil dihapus'
        ]);
    }
    
}
