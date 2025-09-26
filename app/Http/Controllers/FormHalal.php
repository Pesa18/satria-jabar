<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormHalal extends Controller
{
    public function index()
    {
        return view('layanan_satria.halal_form');
    }
}
