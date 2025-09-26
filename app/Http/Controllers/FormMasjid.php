<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormMasjid extends Controller
{
    public function index()
    {
        return view('layanan_satria.masjid_form');
    }
}
