<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Payments;

class IncomeController extends controller
{
    public function index()
    {
        $thisMonth = date('m');
        $thisYear = date('Y');
        $lastYear = date('Y') - 1;
        $thisYearCount = 0;
        $lastYearCount = 0;
        $thisMonthCount = 0;
        $thisHalfYearCount = 0;
        $thisQuarterCount = 0;


        $paymentsThisYear = Payments::select('*')
            ->where('YEAR(createdOn)', '=', $thisYear)->getAll();

        foreach ($paymentsThisYear as $data) {
            $thisYearCount = $thisYearCount + $data->price;
        }


        $paymentsLastYear = Payments::select('*')
            ->where('YEAR(createdOn)', '=', $lastYear)->getAll();

        foreach ($paymentsLastYear as $data) {
            $lastYearCount = $lastYearCount + $data->price;
        }


        $paymentsThisMonth = Payments::select('*')
            ->where('YEAR(createdOn)', '=', $thisYear)
            ->where('MONTH(createdOn)', '=', $thisMonth)
            ->getAll();

        foreach ($paymentsThisMonth as $data) {
            $thisMonthCount = $thisMonthCount + $data->price;
        }


        if ($thisMonth > 6) {
            $paymentsThisHalftYear = Payments::select('*')
                ->where('YEAR(createdOn)', '=', $thisYear)
                ->between('MONTH(createdOn)', '7', $thisMonth)
                ->getAll();
        } else if ($thisMonth <= 6) {
            $paymentsThisHalftYear = Payments::select('*')
                ->where('YEAR(createdOn)', '=', $thisYear)
                ->between('MONTH(createdOn)', '1', $thisMonth)
                ->getAll();
        }

        foreach ($paymentsThisHalftYear as $data) {
            $thisHalfYearCount = $thisHalfYearCount + $data->price;
        }


        if ($thisMonth <= 4) {
            $paymentsThisQuarter = Payments::select('*')
                ->where('YEAR(createdOn)', '=', $thisYear)
                ->between('MONTH(createdOn)', '1', $thisMonth)
                ->getAll();
        } else if ($thisMonth > 4 && $thisMonth <= 8) {
            $paymentsThisQuarter = Payments::select('*')
                ->where('YEAR(createdOn)', '=', $thisYear)
                ->between('MONTH(createdOn)', '5', $thisMonth)
                ->getAll();
        } else if ($thisMonth > 8 && $thisMonth <= 12) {
            $paymentsThisQuarter = Payments::select('*')
                ->where('YEAR(createdOn)', '=', $thisYear)
                ->between('MONTH(createdOn)', '9', $thisMonth)
                ->getAll();
        }

        foreach ($paymentsThisQuarter as $data) {
            $thisQuarterCount = $thisQuarterCount + $data->price;
        }


        return view('admin/income', ['thisYearCount' => $thisYearCount, 'lastYearCount' => $lastYearCount, 'thisMonthCount' => $thisMonthCount,
            'thisHalfYearCount' => $thisHalfYearCount, 'thisQuarterCount' => $thisQuarterCount]);
    }
}
