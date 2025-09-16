<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MobilModel;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    protected $request;
    protected $validation;

    protected $mobil_model;
    public function __construct()
    {
        helper(['url', 'form']);
        $this->request = \Config\Services::request();
        $this->validation = \Config\Services::validation();
        $this->mobil_model = new MobilModel();
    }
    public function index()
    {
        $data = [
            'title' => "Dashboard Admin | Rental Mobil"
        ];

        return view('admin/index', $data);
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
