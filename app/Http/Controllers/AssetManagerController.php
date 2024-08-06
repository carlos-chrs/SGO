<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetManagerController 
{
    public function index()
    {
       
        return view('assets.adminasets');
    }
}