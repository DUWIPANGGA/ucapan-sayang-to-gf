<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValentineController extends Controller
{
    public function index()
    {
        return view('valentine');
    }
}
