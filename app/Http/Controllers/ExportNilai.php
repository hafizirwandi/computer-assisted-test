<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportNilai extends Controller
{
    public function index()
    {
        return view('export-nilai.index');
    }
    public function xx()
    {
        return Excel::download(new DataExport, 'users.xlsx');
    }
}
