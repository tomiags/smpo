<?php

namespace App\Controllers;

use App\Models\DepartemenModel;
use CodeIgniter\Controller;

class Departemen extends Controller
{
    protected $departemenModel;

    public function __construct()
    {
        $this->departemenModel = new DepartemenModel();
    }


    public function index()
    {
        $departemens = $this->departemenModel->findAll();

        return view('departemen/index', [
            'departemens' => $departemens
        ]);
    }


    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_departemen'   => 'required',
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $this->departemenModel->insert([
            'nama_departemen'   => strtoupper($this->request->getPost('nama_departemen')),
            'created_by'        => user_id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Departemen berhasil ditambahkan'
        ]);
    }


    public function show($id)
    {
        $departemen = $this->departemenModel->find($id);

        if (!$departemen) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Departemen tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($departemen);
    }


    public function update($id)
    {
        $departemen = $this->departemenModel->find($id);

        if (!$departemen) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Departemen tidak ditemukan'
            ]);
        }

        $validation = \Config\Services::validation();

        $rules = [
            'nama_departemen'   => 'required',
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $this->departemenModel->update($id, [
            'nama_departemen'   => strtoupper($this->request->getPost('nama_departemen')),
            'updated_by'      => user_id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Departemen berhasil diperbarui'
        ]);
    }


    public function delete($id)
    {
        $departemen = $this->departemenModel->find($id);

        if (!$departemen) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Departemen tidak ditemukan'
            ]);
        }

        $this->departemenModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Departemen berhasil dihapus'
        ]);
    }
}
