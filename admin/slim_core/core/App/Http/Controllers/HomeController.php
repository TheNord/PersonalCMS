<?php

namespace App\Http\Controllers;

class HomeController
{
    public function home() {
        return view('app/hello');
    }

    public function about() {
        return view('app/about');
    }
}