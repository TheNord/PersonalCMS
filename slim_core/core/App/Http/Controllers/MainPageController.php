<?php

namespace App\Http\Controllers;

use App\ReadModel\StatisticsReadRepository;

class MainPageController
{
    public function index()
    {
        $statistics = new StatisticsReadRepository();

        $statistics->addView();

        return view('main/home');
    }
}