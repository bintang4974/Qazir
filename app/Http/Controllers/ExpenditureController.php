<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use Illuminate\Http\Request;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('expenditure.index');
    }

    public function data()
    {
        $expenditure = Expenditure::orderBy('id', 'desc')->get();

        return datatables()
            ->of($expenditure)
            ->addIndexColumn()
            ->addColumn('nominal', function ($expenditure) {
                return 'Rp. ' . format_uang($expenditure->nominal);
            })
            ->addColumn('action', function ($expenditure) {
                return '
                <button type="button" onclick="editForm(`' . route('expenditure.update', $expenditure->id) . '`)" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                <button type="button" onclick="deleteData(`' . route('expenditure.destroy', $expenditure->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
        Expenditure::create($request->all());

        return response()->json('Data Create Successfully!', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expenditure = Expenditure::find($id);

        return response()->json($expenditure);
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
        $expenditure = Expenditure::find($id);
        $expenditure->update($request->all());

        return response()->json('Data Create Successfully!', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expenditure = Expenditure::find($id);
        $expenditure->delete();

        return response(null, 204);
    }
}
