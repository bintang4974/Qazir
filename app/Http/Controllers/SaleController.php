<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function create()
    {
        $sale = new Sale;
        $sale->member_id = null;
        $sale->total_item = 0;
        $sale->total_price = 0;
        $sale->discount = 0;
        $sale->payment = 0;
        $sale->accepted = 0;
        $sale->user_id = auth()->id();
        $sale->save();

        // create session dengan id sale
        session(['id_sale' => $sale->id]);
        return redirect()->route('transaction.index');
    }
}
