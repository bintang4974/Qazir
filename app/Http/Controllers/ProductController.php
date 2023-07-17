<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all()->pluck('name', 'id');

        return view('product.index', compact('category'));
    }

    public function data()
    {
        $product = Product::orderBy('id', 'desc')->get();

        return datatables()
            ->of($product)
            ->addIndexColumn()
            ->addColumn('select_all', function ($product) {
                return '<input type="checkbox" name="id[]" value="' . $product->id . '">';
            })
            ->addColumn('code', function ($product) {
                return '<span class="badge badge-secondary">' . $product->code . '</span>';
            })
            ->addColumn('category', function ($product) {
                return $product->category->name;
            })
            ->addColumn('purchase_price', function ($product) {
                return format_uang($product->purchase_price);
            })
            ->addColumn('selling_price', function ($product) {
                return format_uang($product->selling_price);
            })
            ->addColumn('action', function ($product) {
                return '
                <button type="button" onclick="editForm(`' . route('product.update', $product->id) . '`)" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                <button type="button" onclick="deleteData(`' . route('product.destroy', $product->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action', 'code', 'select_all'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::latest()->first() ?? new Product();
        $request['code'] = 'A' . add_leading_zero((int)$product->id + 1, 6);
        $product = Product::create($request->all());

        return response()->json('Data Create Successfully!', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        return response()->json($product);
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
        $product = Product::find($id) ?? new Product();
        $product->update($request->all());

        return response()->json('Data Create Successfully!', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id as $id) {
            Product::find($id)->delete();
        }

        return response(null, 204);
    }

    public function printBarcode(Request $request)
    {
        $dataProduct = array();
        foreach ($request->id as $id) {
            $product = Product::find($id);
            $dataProduct[] = $product;
        }

        $no = 1;
        $pdf = PDF::loadView('product.barcode', compact('dataProduct', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('product.pdf');
    }
}
