<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchase_detail;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::all();

        return view('purchase.index', compact('supplier'));
    }

    public function data()
    {
        $purchase = Purchase::orderBy('id', 'desc')->get();

        return datatables()
            ->of($purchase)
            ->addIndexColumn()
            ->addColumn('total_price', function ($purchase) {
                return 'Rp. ' . format_uang($purchase->total_price);
            })
            ->addColumn('payment', function ($purchase) {
                return 'Rp. ' . format_uang($purchase->payment);
            })
            ->addColumn('date', function ($purchase) {
                return tanggal_indonesia($purchase->created_at, false);
            })
            ->addColumn('supplier', function ($purchase) {
                return $purchase->supplier->name;
            })
            ->editColumn('discount', function ($purchase) {
                return $purchase->discount . '%';
            })
            ->addColumn('action', function ($purchase) {
                return '
                <button type="button" onclick="showDetail(`' . route('purchase.show', $purchase->id) . '`)" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></button>
                <button type="button" onclick="deleteData(`' . route('purchase.destroy', $purchase->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $purchase = new Purchase;
        $purchase->supplier_id = $id;
        $purchase->total_item = 0;
        $purchase->total_price = 0;
        $purchase->discount = 0;
        $purchase->payment = 0;
        $purchase->save();

        session(['id_purchase' => $purchase->id]);
        session(['id_supplier' => $purchase->supplier_id]);

        return redirect()->route('purchase_detail.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $purchase = Purchase::findOrFail($request->id_purchase);
        $purchase->total_item = $request->total_item;
        $purchase->total_price = $request->total;
        $purchase->payment = $request->pay;
        $purchase->discount = $request->discount;
        $purchase->update();

        $detail = Purchase_detail::where('purchase_id', $purchase->id)->get();
        foreach ($detail as $item) {
            $product = Product::find($item->product_id);
            $product->stock += $item->amount;
            $product->update();
        }

        return redirect()->route('purchase.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detail = Purchase_detail::with('product')->where('purchase_id', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('code', function ($detail) {
                return '<span class="badge badge-secondary">' . $detail->product->code . '</span>';
            })
            ->addColumn('name', function ($detail) {
                return $detail->product->name;
            })
            ->addColumn('purchase_price', function ($detail) {
                return 'Rp. ' . format_uang($detail->purchase_price);
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::find($id);
        $detail = Purchase_detail::where('id', $purchase->id)->get();
        foreach ($detail as $item) {
            $item->delete();
        }
        $purchase->delete();

        return response(null, 204);
    }
}
