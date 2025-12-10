<?php

namespace App\Database\Seeds;

use Myth\Auth\Password;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'email'         => 'admin@smpo.com',
            'username'      => 'admin',
            'password_hash' => Password::hash('admin123'),
            'active'        => 1
        ];

        $this->db->table('users')->insert($data);
    }
}
