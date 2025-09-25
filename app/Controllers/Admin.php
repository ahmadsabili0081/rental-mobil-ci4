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
                            'rules' => "required|is_unique[tb_mobil.nama]",
                            'errors' => [
                                'required' => "Kolom Nama Mobil harus terisi!",
                                'is_unique' => "{field} Sudah terdaftar disistem!"
                            ],
                        ],
                        'no_plat' => [
                            'rules' => "required|is_unique[tb_mobil.nama]",
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
                        'gambar' => [
                            'rules' => 'max_size[gambar,1024]|is_image[gambar]',
                            'errors' => [
                                'max_size' => "Maksimal Upload Gambar 1Mb"
                            ]
                        ],
                    ];

                    if (!$this->validate($rules)) {
                        return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $this->validator->getErrors()]);
                    } else {
                        $file = $this->request->getFile('gambar');
                        $path = 'gambar/admin/mobil/';
                        $file_name = 'mobil' . "_" . $file->getRandomName();

                        $upload_image = \Config\Services::image()
                            ->withFile($file)
                            ->resize(450, 450, true, 'height')
                            ->save($path . $file_name);

                        // if ($upload_image) {
                        //     if ($old_file_picture != null && file_exists($path . $old_file_picture) && $old_file_picture != 'default.jpg') {
                        //         unlink($path . $old_file_picture);
                        //     }
                        //     $this->user_model->where('id_user', $user_info['id_user'])
                        //         ->set(['picture' => $new_file_name])
                        //         ->update();
                        //     echo json_encode(['status' => 1, 'msg' => 'Profile anda berhasil diperbarui!']);
                        // } else {
                        //     echo json_encode(['status' => 0, 'msg' => 'Ada kesalahan saat mengubah foto!']);
                        // }

                        if ($upload_image) {
                            $nama_file = $file_name;
                        } else {
                            $nama_file = 'default.jpg';
                        }

                        $hasil = $this->mobil_model->save([
                            'nama' => $this->request->getPost('nama'),
                            'no_plat' => $this->request->getPost('no_plat'),
                            'harga_sewa' => str_replace('.', '', $this->request->getPost('harga_sewa')),
                            'gambar' => $nama_file
                        ]);

                        if ($hasil) {
                            $result = ['status' => 1, 'msg' => "Berhasil menambahkan Data!", 'token' => csrf_hash()];
                        } else {
                            $result = ['status' => 0, 'msg' => "Gagal menambahkan Data!", 'token' => csrf_hash()];
                        }

                        return json_encode($result);
                    }
                }
                break;
            case 'edit':
                if ($this->request->isAJAX()) {
                    $rules = [
                        'nama' => [
                            'rules' => "required",
                            'errors' => [
                                'required' => "Kolom Nama Mobil harus terisi!",
                            ],
                        ],
                        'no_plat' => [
                            'rules' => "required",
                            'errors' => [
                                'required' => "Kolom No. Plat harus terisi!",
                            ],
                        ],
                        'harga_sewa' => [
                            'rules' => "required",
                            'errors' => [
                                'required' => "Kolom Harga Sewa harus terisi!",
                            ],
                        ],
                        'gambar' => [
                            'rules' => 'max_size[gambar,1024]|is_image[gambar]',
                            'errors' => [
                                'max_size' => "Maksimal Upload Gambar 1Mb"
                            ]
                        ],
                    ];

                    if (!$this->validate($rules)) {
                        return $this->response->setJSON(['status' => 0, 'token' => csrf_hash(), 'error' => $this->validator->getErrors()]);
                    } else {
                        $id_mobil = $this->request->getPost('id_mobil');
                        $info_car = $this->mobil_model->where('id_mobil', $id_mobil)->first();
                        $old_file_picture = $info_car['gambar'];
                        $file = $this->request->getFile('gambar');
                        $path = 'gambar/admin/mobil/';
                        $file_name = 'mobil' . "_" . $file->getRandomName();

                        $upload_image = \Config\Services::image()
                            ->withFile($file)
                            ->resize(450, 450, true, 'height')
                            ->save($path . $file_name);

                        if ($upload_image) {
                            if ($old_file_picture != null && file_exists($path . $old_file_picture) && $old_file_picture != 'default.jpg') {
                                unlink($path . $old_file_picture);
                            }
                            $this->mobil_model->where('id_mobil', $id_mobil)
                                ->set(['gambar' => $file_name])
                                ->update();
                        }
                        $update = $this->mobil_model->save([
                            'id_mobil' => $id_mobil,
                            'nama' => $this->request->getPost('nama'),
                            'no_plat' => $this->request->getPost('no_plat'),
                            'harga_sewa' => str_replace('.', '', $this->request->getPost('harga_sewa')),
                        ]);

                        if ($update) {
                            $result = ['status' => 1, 'msg' => "Berhasil Mengedit Data!", 'token' => csrf_hash()];
                        } else {
                            $result = ['status' => 0, 'msg' => "Gagal Mengedit Data!", 'token' => csrf_hash()];
                        }

                        return json_encode($result);
                    }
                }
                break;
            case 'ambil_data':
                $id_mobil = $this->request->getPost('idMobil');
                $hasil = $this->mobil_model->where(['id_mobil' => $id_mobil])->find();

                if ($hasil) {
                    $result = ['status' => 1, 'msg' => "Berhasil Mendapatkan Data!", 'data' => $hasil];
                } else {
                    $result = ['status' => 0, 'msg' => "Gagal Mendapatkan Data!", 'data' => $hasil];
                }

                break;
            case 'hapus':
                $id_mobil = $this->request->getPost('idMobil');
                $info_gambar = $this->mobil_model->where(['id_mobil' => $id_mobil])->first();
                $file = $info_gambar['gambar'];
                $path = "gambar/admin/mobil/";

                if ($info_gambar) {
                    if ($file != null && file_exists($path . $file) && $file != 'default.jpg') {
                        unlink($path . $file);
                    }
                }

                $hasil = $this->mobil_model->delete(['id_mobil' => $id_mobil]);

                if ($hasil) {
                    $result = ['status' => 1, 'msg' => "Berhasil Menghapus Data!"];
                } else {
                    $result = ['status' => 0, 'msg' => "Gagal Menghapus Data!"];
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
