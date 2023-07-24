<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Sale_detail;
use App\Models\Setting;
use Illuminate\Http\Request;

class SaleDetailController extends Controller
{
    public function index()
    {
        $product = Product::orderBy('name')->get();
        $member = Member::orderBy('name')->get();
        $discount = Setting::first()->discount ?? 0;

        // cek apakah ada transaksi yang sedang berjalan
        if ($id_sale = session('id_sale')) {
            // cari apakah ada pembayaran penjualan sebelumnya
            $sale = Sale::find($id_sale);
            // cari member apakah ada penjualan sebelumnya
            $memberSelected = $sale->member ?? new Member;

            return view('sale_detail.index', compact('product', 'member', 'discount', 'id_sale', 'sale', 'memberSelected'));
        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaction.new');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function data($id)
    {
        $detail = Sale_detail::with('product')->where('sale_id', $id)->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['code_product'] = '<span class="badge badge-secondary">' . $item->product['code'] . '</span>';
            $row['name_product'] = $item->product['name'];
            $row['selling_price'] = 'Rp. ' . format_uang($item->selling_price);
            $row['amount'] = '<input type="number" class="form-control form-control-sm quantity" data-id="' . $item->id . '" value="' . $item->amount . '">';
            $row['discount'] = $item->discount . '%';
            $row['subtotal'] = 'Rp. ' . format_uang($item->subtotal);
            $row['action'] = '<button type="button" onclick="deleteData(`' . route('transaction.destroy', $item->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
            $data[] = $row;

            $total += $item->selling_price * $item->amount;
            $total_item += $item->amount;
        }
        $data[] = [
            'code_product' => '<div class="total hide">' . $total . '</div> <div class="total_item hide">' . $total_item . '</div>',
            'name_product' => '',
            'selling_price' => '',
            'amount' => '',
            'discount' => '',
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

        $detail = new Sale_detail;
        $detail->sale_id = $request->id_sale;
        $detail->product_id = $product->id;
        $detail->selling_price = $product->selling_price;
        $detail->amount = 1;
        $detail->discount = 0;
        $detail->subtotal = $product->selling_price;
        $detail->save();

        return response()->json('Data Create Successfully!', 200);
    }

    public function update(Request $request, $id)
    {
        $detail = Sale_detail::find($id);
        $detail->amount = $request->amount;
        $detail->subtotal = $detail->selling_price * $request->amount;
        $detail->update();
    }

    public function destroy(string $id)
    {
        $detail = Sale_detail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($discount = 0, $total, $accepted)
    {
        $pay = $total - ($discount / 100 * $total);
        $money_changes = ($accepted != 0) ? $accepted - $pay : 0;
        $data = [
            'totalrp' => format_uang($total),
            'pay' => $pay,
            'payrp' => format_uang($pay),
            'terbilang' => ucwords(terbilang($pay) . ' Rupiah'),
            'money_changes' => format_uang($money_changes),
            'kembali_terbilang' => ucwords(terbilang($money_changes) . ' Rupiah'),
        ];

        return response()->json($data);
    }
}
