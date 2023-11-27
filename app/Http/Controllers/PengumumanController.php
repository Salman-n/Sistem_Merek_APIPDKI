<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
     //
     function index() {
        
        $pengumumans = Pengumuman::orderBy('id','desc')->get();

        return view('pengumuman',compact("pengumumans"));

    }
}
