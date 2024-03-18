<?php

namespace App\Http\Controllers;

use App\Models\ButirSoal;
use Illuminate\Http\Request;

class CatController extends Controller
{

    public function index()
    {
        $data['butirsoal'] = ButirSoal::first();
        // dd($data);
        return view('cat.index', $data);
    }
}
