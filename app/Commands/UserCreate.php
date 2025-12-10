<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Myth\Auth\Models\UserModel;
use App\Models\DetailUserModel;

class UserCreate extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'user:create';
    protected $description = 'Create new user via CLI';

    public function run(array $params)
    {
        $userModel   = new UserModel();
        $detailModel = new DetailUserModel();

        CLI::write('=== Create User ===', 'yellow');

        // Data login
        $email    = CLI::prompt('Email');
        $username = CLI::prompt('Username');
        $password = CLI::prompt('Password');

        // Insert ke tabel users
        $userId = $userModel->insert([
            'email'    => $email,
            'username' => $username,
            'password' => $password,
        ]);

        // Detail user
        CLI::write('=== Detail User ===', 'yellow');

        $nama_user    = CLI::prompt('Nama User');
        $jabatan      = CLI::prompt('Jabatan');
        $tgl_lahir    = CLI::prompt('Tanggal Lahir (YYYY-MM-DD)');
        $jenkel       = CLI::prompt('Jenis Kelamin (L/P)');
        $tempat_lahir = CLI::prompt('Tempat Lahir');
        $no_tlp       = CLI::prompt('No Telp');

        // Insert ke tabel detail_users
        $detailModel->insert([
            'user_id'      => $userId,
            'nama_user'    => $nama_user,
            'jabatan'      => $jabatan,
            'tgl_lahir'    => $tgl_lahir,
            'jenkel'       => $jenkel,
            'tempat_lahir' => $tempat_lahir,
            'no_tlp'       => $no_tlp
        ]);

        CLI::write('User berhasil dibuat!', 'green');
        CLI::write("User ID: $userId", 'green');
    }
}
