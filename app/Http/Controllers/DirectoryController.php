<?php

namespace App\Http\Controllers;

class DirectoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify.doctor')->only('index');
    }
    public function index()
    {
        return view('pages.directory.index');
    }
}
