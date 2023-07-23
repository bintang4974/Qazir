<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
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
        $discount = Purchase::find($id_purchase)->discount ?? 0;

        // return session('id_supplier');
        if (!$supplier) {
            abort(404);
        }

        return view('purchase_detail.index', compact('id_purchase', 'product', 'supplier', 'discount'));
    }

    public function data($id)
    {
        $detail = Purchase_detail::with('product')->where('purchase_id', $id)->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['code_product'] = '<span class="badge badge-secondary">' . $item->product['code'] . '</span>';
            $row['name_product'] = $item->product['name'];
            $row['purchase_price'] = 'Rp. ' . format_uang($item->purchase_price);
            $row['amount'] = '<input type="number" class="form-control form-control-sm quantity" data-id="' . $item->id . '" value="' . $item->amount . '">';
            $row['subtotal'] = 'Rp. ' . format_uang($item->subtotal);
            $row['action'] = '<button type="button" onclick="deleteData(`' . route('purchase_detail.destroy', $item->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
            $data[] = $row;

            $total += $item->purchase_price * $item->amount;
            $total_item += $item->amount;
        }
        $data[] = [
            'code_product' => '<div class="total hide">' . $total . '</div> <div class="total_item hide">' . $total_item . '</div>',
            'name_product' => '',
            'purchase_price' => '',
            'amount' => '',
            'subtotal' => '',
            'action' => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['action', 'code_product', 'purchase_price', 'amount', 'subtotal'])
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

    public function update(Request $request, $id)
    {
        $detail = Purchase_detail::find($id);
        $detail->amount = $request->amount;
        $detail->subtotal = $detail->purchase_price * $request->amount;
        $detail->update();
    }

    public function loadForm($discount, $total)
    {
        $pay = $total - ($discount / 100 * $total);
        $data = [
            'totalrp' => format_uang($total),
            'pay' => $pay,
            'payrp' => format_uang($pay),
            'terbilang' => ucwords(terbilang($pay) . ' Rupiah')
        ];

        return response()->json($data);
    }
}
