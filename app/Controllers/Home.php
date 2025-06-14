<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home', [
            'title' => 'Halaman Home',
            'content' => 'Selamat datang di website kami! Ini adalah halaman utama yang dibuat dengan CodeIgniter 4.'
        ]);
    }
}
