<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NoPam;
use App\Models\User;
use Illuminate\Http\Request;

class PamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pams = NoPam::all();
        return view('pam', compact('pams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('pam-create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'atas_nama' => 'required|string',
            'no_pam' => 'required|string',
            'tgl_pemasangan' => 'nullable|date',
            'alamat' => 'required|string',
            'tipe' => 'nullable|string',
        ]);

        NoPam::create($request->all());

        return redirect()->route('admin.pams.index')->with('success', 'NoPam created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoPam $noPam)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'atas_nama' => 'required|string',
            'no_pam' => 'required|string',
            'tgl_pemasangan' => 'nullable|date',
            'alamat' => 'required|string',
            'tipe' => 'nullable|string',
        ]);

        $noPam->update($request->all());

        return redirect()->route('admin.pams.index')->with('success', 'NoPam updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        NoPam::find($id)->delete();

        return redirect()->route('admin.pams.index')
            ->with('success', 'Pam Success deleted');
    }
}
