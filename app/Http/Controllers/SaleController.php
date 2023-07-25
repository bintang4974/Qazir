<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Models\Setting;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return view('sale.index');
    }

    public function data()
    {
        $sale = Sale::orderBy('id', 'desc')->get();

        return datatables()
            ->of($sale)
            ->addIndexColumn()
            ->addColumn('total_price', function ($sale) {
                return 'Rp. ' . format_uang($sale->total_price);
            })
            ->addColumn('payment', function ($sale) {
                return 'Rp. ' . format_uang($sale->payment);
            })
            ->addColumn('date', function ($sale) {
                return tanggal_indonesia($sale->created_at, false);
            })
            ->addColumn('member_code', function ($sale) {
                return '<span class="badge badge-secondary">' . $sale->member->code ?? '' . '</span>';
            })
            ->editColumn('discount', function ($sale) {
                return $sale->discount . '%';
            })
            ->editColumn('cashier', function ($sale) {
                return $sale->user->name ?? '';
            })
            ->addColumn('action', function ($sale) {
                return '
                <button type="button" onclick="showDetail(`' . route('sale.show', $sale->id) . '`)" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></button>
                <button type="button" onclick="deleteData(`' . route('sale.destroy', $sale->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action', 'member_code'])
            ->make(true);
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

        return redirect()->route('transaction.finish');
    }

    public function show(string $id)
    {
        $detail = Sale_detail::with('product')->where('sale_id', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('code', function ($detail) {
                return '<span class="badge badge-secondary">' . $detail->product->code . '</span>';
            })
            ->addColumn('name', function ($detail) {
                return $detail->product->name;
            })
            ->addColumn('selling_price', function ($detail) {
                return 'Rp. ' . format_uang($detail->selling_price);
            })
            ->addColumn('amount', function ($detail) {
                return format_uang($detail->amount);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. ' . format_uang($detail->subtotal);
            })
            ->rawColumns(['code'])
            ->make(true);
    }

    public function destroy(string $id)
    {
        $sale = Sale::find($id);
        $detail = Sale_detail::where('id', $sale->id)->get();
        foreach ($detail as $item) {
            $item->delete();
        }
        $sale->delete();

        return response(null, 204);
    }

    public function finish()
    {
        $setting = Setting::first();

        return view('sale.finish', compact('setting'));
    }

    public function smallNote()
    {
        $setting = Setting::first();
        $sale = Sale::find(session('id_sale'));
        if (!$sale) {
            abort(404);
        }
        $detail = Sale_detail::with('product')->where('sale_id', session('id_sale'))->get();
        return view('sale.small_note', compact('setting', 'sale', 'detail'));
    }

    public function bigNote()
    {
    }
}
