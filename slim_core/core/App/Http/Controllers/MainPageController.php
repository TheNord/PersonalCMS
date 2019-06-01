<?php

namespace App\Http\Controllers;

use App\ReadModel\PageMetaRepository;
use App\ReadModel\SettingsRepository;
use App\ReadModel\StatisticsReadRepository;

class MainPageController
{
    public function index()
    {
        $statistics = new StatisticsReadRepository();

        $statistics->addView();

        $counters = (new SettingsRepository())->find('counters');

        $meta = (new PageMetaRepository())->find('home');

        return view('main/home', compact('counters', 'meta'));
    }
}