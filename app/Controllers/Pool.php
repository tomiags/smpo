<?php

namespace App\Controllers;

use App\Models\PoolModel;
use CodeIgniter\Controller;

class Pool extends Controller
{
    protected $poolModel;

    public function __construct()
    {
        $this->poolModel = new PoolModel();
    }


    public function index()
    {
        $pools = $this->poolModel->findAll();

        return view('pool/index', [
            'pools' => $pools
        ]);
    }


    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_pool'   => 'required',
            'lokasi_pool' => 'required',
            'kota_pool'   => 'required',
            'prov_pool'   => 'required',
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        /*
        |----------------------------------------------------------------------
        | GENERATE KODE POOL OTOMATIS
        |----------------------------------------------------------------------
        */
        $db = \Config\Database::connect();
        $last = $db->table('pool')
            ->select('kode_pool')
            ->like('kode_pool', 'POOL')
            ->orderBy('kode_pool', 'DESC')
            ->get()
            ->getRow();

        if ($last) {
            // Ambil 3 digit angka terakhir
            $lastNumber = intval(substr($last->kode_pool, 4));
            $newNumber = str_pad($lastNumber + 1, 3, "0", STR_PAD_LEFT);
        } else {
            $newNumber = "001";
        }

        $kode_pool = "POOL" . $newNumber;


        /*
        |----------------------------------------------------------------------
        | INSERT DATA
        |----------------------------------------------------------------------
        */
        $this->poolModel->insert([
            'kode_pool'   => $kode_pool,
            'nama_pool'   => strtoupper($this->request->getPost('nama_pool')), // <- CAPITAL
            'lokasi_pool' => $this->request->getPost('lokasi_pool'),
            'kota_pool'   => strtoupper($this->request->getPost('kota_pool')), // opsional kapital
            'prov_pool'   => strtoupper($this->request->getPost('prov_pool')), // opsional kapital
            'created_by'  => user_id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Pool berhasil ditambahkan',
            'kode_pool' => $kode_pool
        ]);
    }



    public function show($kode_pool)
    {
        $pool = $this->poolModel->find($kode_pool);

        if (!$pool) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Pool tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($pool);
    }


    public function update($kode_pool)
    {
        $validation = \Config\Services::validation();

        // Cek data lama
        $existing = $this->poolModel->find($kode_pool);
        if (!$existing) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Data pool tidak ditemukan'
            ]);
        }

        // RULES
        $rules = [
            'nama_pool'   => 'required',
            'lokasi_pool' => 'required',
            'kota_pool'   => 'required',
            'prov_pool'   => 'required',
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $this->poolModel->update($kode_pool, [
            'nama_pool'   => strtoupper($this->request->getPost('nama_pool')), 
            'lokasi_pool' => $this->request->getPost('lokasi_pool'),
            'kota_pool'   => strtoupper($this->request->getPost('kota_pool')),
            'prov_pool'   => strtoupper($this->request->getPost('prov_pool')),
            'updated_by'  => user_id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Pool berhasil diperbarui'
        ]);
    }



    public function delete($kode_pool)
    {
        $pool = $this->poolModel->find($kode_pool);

        if (!$pool) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Pool tidak ditemukan'
            ]);
        }

        $this->poolModel->delete($kode_pool);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Pool berhasil dihapus'
        ]);
    }
}
