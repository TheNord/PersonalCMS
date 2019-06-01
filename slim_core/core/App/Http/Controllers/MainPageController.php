<?php

namespace App\Http\Controllers;

use App\ReadModel\SettingsRepository;
use App\ReadModel\StatisticsReadRepository;

class MainPageController
{
    public function index()
    {
        $statistics = new StatisticsReadRepository();

        $statistics->addView();

        $counters = (new SettingsRepository())->find('counters');

        return view('main/home', compact('counters'));
    }
}