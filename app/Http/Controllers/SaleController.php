<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Sale_detail;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return "OK";
    }

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

    public function store(Request $request)
    {
        $sale = Sale::findOrFail($request->id_sale);
        $sale->member_id = $request->id_member;
        $sale->total_item = $request->total_item;
        $sale->total_price = $request->total;
        $sale->payment = $request->pay;
        $sale->discount = $request->discount;
        $sale->accepted = $request->accepted;
        $sale->update();

        $detail = Sale_detail::where('sale_id', $sale->id)->get();
        foreach ($detail as $item) {
            $product = Product::find($item->product_id);
            $product->stock -= $item->amount;
            $product->update();
        }

        return redirect()->route('sale.index');
    }
}
