<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormKiblat extends Controller
{
    public function index()
    {
        return view('layanan_satria.kiblat_form');
    }
}
