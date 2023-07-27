<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('category.index');
    }

    public function data()
    {
        $category = Category::orderBy('id', 'desc')->get();

        return datatables()
            ->of($category)
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                return '
                <button type="button" onclick="editForm(`' . route('category.update', $category->id) . '`)" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                <button type="button" onclick="deleteData(`' . route('category.destroy', $category->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
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
        $category = new Category;
        $category->name = $request->name;
        $category->save();

        return response()->json('Data Create Successfully!', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        return response()->json($category);
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
        $category = Category::find($id);
        $category->name = $request->name;
        $category->update();

        return response()->json('Data Create Successfully!', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();

        return response(null, 204);
    }
}
