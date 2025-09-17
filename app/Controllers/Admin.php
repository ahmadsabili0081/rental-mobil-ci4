<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MobilModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Users;
class Admin extends BaseController
{
    protected $request;
    protected $validation;

    protected $mobil_model;
    protected $users_model;
    public function __construct()
    {
        helper(['url', 'form']);
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->mobil_model = new MobilModel();
        $this->users_model = new Users();
    }
    public function index()
    {
        $data = [
            'title' => "Dashboard Admin | Rental Mobil"
        ];

        return view('admin/index', $data);
    }

    public function user()
    {
        $data = [
            'title' => "Data User | Rental Mobil"
        ];

        return view('admin/user/index', $data);
    }

    public function action_user($action = '')
    {
        switch ($action) {

            case 'ambil':
                $get_data = $this->UserModel->findAll();

                if ($get_data) {
                    $result = ['status' => 1, 'msg' => "Berhasil Mendapatkan Data!", "data" => $get_data];
                } else {
                    $result = ['status' => 0, 'msg' => "Gagal Mendapatkan Data!", "data" => $get_data];
                }
                break;
        }

        return json_encode($result);
    }

    public function car()
    {
        $data = [
            'title' => "Data Mobil | Rental Mobil"
        ];

        return view('admin/mobil/index', $data);
    }

    public function action_car($action = '')
    {
        switch ($action) {
            case 'tambah':
                if ($this->request->isAJAX()) {
                    $rules = [
                        'nama' => [
                            'rules' => "required|is_unique[tb_mobil]",
                            'errors' => [
                                'required' => "Kolom Nama Mobil harus terisi!",
                                'is_unique' => "{field} Sudah terdaftar disistem!"
                            ],
                        ],
                        'no_plat' => [
                            'rules' => "required|is_unique[tb_mobil]",
                            'errors' => [
                                'required' => "Kolom No. Plat harus terisi!",
                                'is_unique' => "{field} Sudah terdaftar disistem!"
                            ],
                        ],
                        'harga_sewa' => [
                            'rules' => "required",
                            'errors' => [
                                'required' => "Kolom Harga Sewa harus terisi!",
                            ],
                        ],
                    ];

                    if (!$this->validate($rules)) {
                        return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $this->validator->getErrors()]);
                    } else {
                        echo "masuk sini";
                    }
                }
                break;
            case 'ambil':
                $get_data = $this->mobil_model->findAll();

                if ($get_data) {
                    $result = ['status' => 1, 'msg' => "Berhasil Mendapatkan Data!", "data" => $get_data];
                } else {
                    $result = ['status' => 0, 'msg' => "Gagal Mendapatkan Data!", "data" => $get_data];
                }
                break;
        }

        return json_encode($result);
    }
}
