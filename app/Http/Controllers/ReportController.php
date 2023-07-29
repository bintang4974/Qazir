<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $endDate = date('Y-m-d');

        if ($request->has('start_date') && $request->start_date != "" && $request->has('end_date') && $request->end_date) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
        }

        return view('report.index', compact('startDate', 'endDate'));
    }

    public function data($begin, $end)
    {
        $no = 1;
        $data = array();
        $income = 0;
        $total_income = 0;

        while (strtotime($begin) <= strtotime($end)) {
            $date = $begin;
            $begin = date('Y-m-d', strtotime("+1 day", strtotime($begin)));

            $total_sale = Sale::where('created_at', 'LIKE', "%$date%")->sum('payment');
            $total_purchase = Purchase::where('created_at', 'LIKE', "%$date%")->sum('payment');
            $total_expenditure = Expenditure::where('created_at', 'LIKE', "%$date%")->sum('nominal');

            $income = $total_sale - $total_purchase - $total_expenditure;
            $total_income += $income;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['date'] = tanggal_indonesia($date, false);
            $row['sale'] = format_uang($total_sale);
            $row['purchase'] = format_uang($total_purchase);
            $row['expenditure'] = format_uang($total_expenditure);
            $row['income'] = format_uang($income);

            $data[] = $row;
        }

        $data[] = [
            'DT_RowIndex' => '',
            'date' => '',
            'sale' => '',
            'purchase' => '',
            'expenditure' => 'Total Pendapatan',
            'income' => format_uang($total_income),
        ];

        return datatables()
            ->of($data)
            ->make(true);
    }

    public function refresh(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return view('report.index', compact('startDate', 'endDate'));
    }
}
