<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\Users;

class Auth extends BaseController
{

    protected $request;
    protected $validation;
    protected $users_model;
    public function __construct()
    {
        helper(['url', 'form']);
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->users_model = new Users();
    }
    public function index()
    {
        $data = [
            'title' => 'Auth | Login Rental Mobil'
        ];

        return view('auth/index', $data);
    }

    public function register()
    {
        $data = [
            'title' => "Auth | Registrasi Rental Mobil "
        ];

        return view('auth/register', $data);
    }

    public function proses_submit()
    {
        if ($this->request->isAJAX()) {
            // $field_type_check = filter_var($this->request->getVar('username_email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $rules = [
                'username_email' => [
                    'rules' => 'required|trim|is_unique[tb_users.username_email]',
                    'errors' => [
                        'required' => "Kolom Username / Email harus terisi!"
                    ],
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => "Kolom Nama harus terisi!"
                    ],
                ],
                'no_hp' => [
                    'rules' => "required|trim|max_length[12]|min_length[10]",
                    'errors' => [
                        'required' => 'Kolom No. Hp/Wa harus terisi!',
                        'max_length' => 'Kolom No. Hp/Wa Maksimal 12!',
                        'min_length' => 'Kolom No. Hp/Wa Minimal 10!',
                    ],
                ],
                'password' => [
                    'rules' => "required|trim|matches[password2]|min_length[3]",
                    'errors' => [
                        'required' => "Kolom Password harus terisi!",
                        'matches' => "Password harus sama dengan Konfirmasi Password!",
                        'min_length' => "Password Maksimal 3 Karakter!"
                    ],
                ],
                'password2' => [
                    'rules' => "required|trim|matches[password]|min_length[3]",
                    'errors' => [
                        'required' => "Konfirmasi Password harus terisi!",
                        'matches' => "Konfirmasi harus sama dengan Password!",
                        'min_length' => "Konfirmasi Password Maksimal 3 Karakter!"
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $this->validation->getErrors()]);
            } else {
                $this->users_model->save([
                    'username_email' => $this->request->getVar('username_email'),
                    'nama' => $this->request->getVar('nama'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'password' => Hash::set_hash($this->request->getVar('password')),
                    'id_role' => 2,
                ]);

                return $this->response->setJSON(['status' => 1, 'msg' => "Berhasil Registrasi"]);
            }
        }
    }
}
