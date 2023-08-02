<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expenditure;
use App\Models\Member;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $category = Category::count();
        $product = Product::count();
        $supplier = Supplier::count();
        $member = Member::count();

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');

        $data_date = array();
        $data_income = array();

        // function temporary untuk mengambil data tanggal dan pendapatan berdasarkan tanggal
        while (strtotime($start_date) <= strtotime($end_date)) {
            $data_date[] = (int) substr($start_date, 8, 2);

            $total_sale = Sale::where('created_at', 'LIKE', "%$start_date%")->sum('payment');
            $total_purchase = Purchase::where('created_at', 'LIKE', "%$start_date%")->sum('payment');
            $total_expenditure = Expenditure::where('created_at', 'LIKE', "%$start_date%")->sum('nominal');

            $income = $total_sale - $total_purchase - $total_expenditure;
            $data_income[] += $income;

            $start_date = date('Y-m-d', strtotime("+1 day", strtotime($start_date)));
        }

        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('category', 'product', 'supplier', 'member', 'start_date', 'end_date', 'data_date', 'data_income'));
        } else {
            return view('cashier.dashboard');
        }
    }
}
