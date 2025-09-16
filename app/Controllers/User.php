<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }
    public function index()
    {
        $data = [
            'title' => "Dashboard User | Rental Mobil"
        ];
        return view('user/index', $data);
    }
}
