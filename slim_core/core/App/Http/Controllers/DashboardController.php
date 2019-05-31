<?php

namespace App\Http\Controllers;

use App\ReadModel\StatisticsReadRepository;

class DashboardController
{
    public function dashboard() {
        $statisticsRepository = new StatisticsReadRepository();
        $statistics = $statisticsRepository->getAllStatistics();

        $datesArray = [];
        $viewsArray = [];

        foreach ($statistics as $day) {
            $datesArray[] = $day->getDate()->format('d-m-Y');
            $viewsArray[] = $day->getViewsCount();
        }

        $datesResult = "'" . implode("', '", $datesArray) . "'";
        $viewsResult = implode(', ', $viewsArray);

        return view('app/dashboard', ['datesResult' => $datesResult, 'viewsResult' => $viewsResult]);
    }
}