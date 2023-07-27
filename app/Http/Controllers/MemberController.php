<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('member.index');
    }

    public function data()
    {
        $member = Member::orderBy('id', 'desc')->get();

        return datatables()
            ->of($member)
            ->addIndexColumn()
            ->addColumn('code', function ($member) {
                return '<span class="badge badge-secondary">' . $member->code . '</span>';
            })
            ->addColumn('action', function ($member) {
                return '
                <button type="button" onclick="editForm(`' . route('member.update', $member->id) . '`)" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                <button type="button" onclick="deleteData(`' . route('member.destroy', $member->id) . '`)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action', 'code'])
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
        $member = Member::latest()->first();
        $code_member = (int) $member->code +1 ?? 1;

        $member = new Member;
        $member->code = add_leading_zero($code_member, 5);
        $member->name = $request->name;
        $member->address = $request->address;
        $member->telephone = $request->telephone;
        $member->save();

        return response()->json('Data Create Successfully!', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = Member::find($id);

        return response()->json($member);
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
        $member = Member::find($id) ?? new Member();
        $member->update($request->all());

        return response()->json('Data Create Successfully!', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::find($id);
        $member->delete();

        return response(null, 204);
    }
}
