<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DetailUserModel;
use App\Models\GroupModel;
use App\Models\GroupUserModel;
use CodeIgniter\Controller;
use CodeIgniter\Shield\Entities\User;
// use CodeIgniter\Shield\Authentication\Passwords\Password;
use Myth\Auth\Password;

class Users extends Controller
{
    protected $userModel;
    protected $detailModel;
    protected $groupModel;
    protected $groupUserModel;

    public function __construct()
    {
        $this->userModel      = new UserModel();
        $this->detailModel    = new DetailUserModel();
        $this->groupModel     = new GroupModel();      
        $this->groupUserModel = new GroupUserModel();   
    }


    public function index()
    {
        $users = $this->userModel
            ->select('users.id, users.email, users.username, users.active,
                    detail_users.nama_user, detail_users.jabatan,
                    auth_groups.name AS group_name')
            ->join('detail_users', 'detail_users.user_id = users.id', 'left')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
            ->findAll();

        // AMBIL DATA GROUPS
        $db = \Config\Database::connect();
        $groups = $db->table('auth_groups')->get()->getResult();

        return view('users/index', [
            'users'  => $users,
            'groups' => $groups 
        ]);
    }


    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'email'      => 'required|valid_email|is_unique[users.email]',
            'username'   => 'required|is_unique[users.username]',
            'password'   => 'required|min_length[6]',
            'nama_user'  => 'required',
            'jabatan'    => 'required', 
        ];

        if (!$validation->setRules($rules)->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        // ========== INSERT USERS TABLE ==========
        $userData = [
            'email'         => $this->request->getPost('email'),
            'username'      => $this->request->getPost('username'),
            'password_hash' => Password::hash($this->request->getPost('password')),
            'active'        => 1,
        ];

        $this->userModel->insert($userData);
        $userId = $this->userModel->getInsertID();


        // =============== AMBIL NAMA GROUP ===============
        $groupId = $this->request->getPost('jabatan');

        $db = \Config\Database::connect();

        $group = $db->table('auth_groups')
                    ->where('id', $groupId)
                    ->get()
                    ->getRow();

        $groupName = $group ? $group->name : null;


        // ========== INSERT DETAIL USERS ==========
        $detailModel = new \App\Models\DetailUserModel();

        $detailModel->insert([
            'user_id'      => $userId,
            'nama_user'    => $this->request->getPost('nama_user'),
            'jabatan'      => $groupName, 
            'jenkel'       => $this->request->getPost('jenkel'),
            'tgl_lahir'    => $this->request->getPost('tgl_lahir'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'no_tlp'       => $this->request->getPost('no_tlp'),
        ]);


        // ========== INSERT auth_groups_users ==========
        $db->table('auth_groups_users')->insert([
            'group_id' => $groupId,
            'user_id'  => $userId,
        ]);


        return $this->response->setJSON([
            'status'  => true,
            'message' => "User berhasil ditambahkan"
        ]);
    }


    public function show($id)
    {
        $user = $this->userModel->select('users.*, detail_users.*')
            ->join('detail_users', 'detail_users.user_id = users.id', 'left')
            ->where('users.id', $id)
            ->first();

        if (!$user) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        return $this->response->setJSON($user);
    }


    public function update($id)
    {
        $user = $this->userModel->find($id);
        if(!$user) return $this->response->setJSON(['status'=>false,'message'=>'User tidak ditemukan']);

        $validation = \Config\Services::validation();
        $rules = [
            'email'      => 'required|valid_email',
            'username'   => 'required',
            'nama_user'  => 'required',
            // 'jabatan'    => 'required',
        ];

        if(!$validation->setRules($rules)->withRequest($this->request)->run()){
            return $this->response->setJSON(['status'=>false,'errors'=>$validation->getErrors()]);
        }

        $dataUser = [
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
        ];

        $password = $this->request->getPost('password');
        if($password) $dataUser['password_hash'] = \Myth\Auth\Password::hash($password);

        $this->userModel->update($id, $dataUser);

        // Update detail user
        $detailModel = new \App\Models\DetailUserModel();
        $detailData = [
            'nama_user'    => $this->request->getPost('nama_user'),
            // 'jabatan'      => $this->request->getPost('jabatan'),
            'jenkel'       => $this->request->getPost('jenkel'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tgl_lahir'    => $this->request->getPost('tgl_lahir'),
            'no_tlp'       => $this->request->getPost('no_tlp'),
        ];
        $detailModel->where('user_id',$id)->set($detailData)->update();

        return $this->response->setJSON(['status'=>true,'message'=>'User berhasil diupdate']);
    }


    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        $this->detailModel->where('user_id', $id)->delete();

        $this->groupUserModel->where('user_id', $id)->delete();

        $this->userModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => "User berhasil dihapus"
        ]);
    }


    public function toggle($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // Toggle active
        $newStatus = $user->active ? 0 : 1;
        $this->userModel->update($id, ['active' => $newStatus]);

        return $this->response->setJSON([
            'status' => true,
            'message' => $newStatus ? 'User diaktifkan' : 'User dinonaktifkan',
            'active' => $newStatus
        ]);
    }


}
