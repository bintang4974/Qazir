<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase_detail;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    public function index()
    {
        $id_purchase = session('id_purchase');
        $product = Product::all();
        $supplier = Supplier::find(session('id_supplier'));

        // return session('id_supplier');
        if (!$supplier) {
            abort(404);
        }

        return view('purchase_detail.index', compact('id_purchase', 'product', 'supplier'));
    }

    public function data($id)
    {
        $detail = Purchase_detail::with('product')->where('purchase_id', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('name_product',  function ($detail) {
                return $detail->product['name'];
            })
            ->addColumn('code_product',  function ($detail) {
                return '<span class="badge badge-secondary">' . $detail->product['code'] . '</span>';
            })
            ->addColumn('purchase_price',  function ($detail) {
                return 'Rp. ' . $detail->purchase_price;
            })
            ->addColumn('subtotal',  function ($detail) {
                return 'Rp. ' . $detail->subtotal;
            })
            ->addColumn('action', function ($detail) {
                return '
                <button type="button" onclick="deleteData(`' . route('purchase_detail.destroy', $detail->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action', 'code_product', 'purchase_price', 'subtotal'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $product = Product::where('id', $request->id_product)->first();
        if (!$product) {
            return response()->json('cant store data!', 400);
        }

        $detail = new Purchase_detail;
        $detail->purchase_id = $request->id_purchase;
        $detail->product_id = $product->id;
        $detail->purchase_price = $product->purchase_price;
        $detail->amount = 1;
        $detail->subtotal = $product->purchase_price;
        $detail->save();

        return response()->json('Data Create Successfully!', 200);
    }

    public function destroy(string $id)
    {
        $detail = Purchase_detail::find($id);
        $detail->delete();

        return response(null, 204);
    }
}
