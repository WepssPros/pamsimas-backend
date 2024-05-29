<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NoPam;
use App\Models\Tagihan_Pam;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tagihanpams = Tagihan_Pam::latest()->get();

        // Menambahkan properti baru untuk menyimpan jarak bulan antara tanggal jatuh tempo dan tanggal saat ini
        $tagihanpams->each(function ($tagihanpam) {
            // Mendapatkan tanggal jatuh tempo dari tagihan
            $dueDate = Carbon::parse($tagihanpam->due_date);
            // Mendapatkan bulan dan tahun dari tanggal saat ini
            $currentMonth = Carbon::now()->format('m');
            $currentYear = Carbon::now()->format('Y');
            // Mendapatkan bulan dan tahun dari tanggal jatuh tempo
            $dueMonth = $dueDate->format('m');
            $dueYear = $dueDate->format('Y');

            // Menghitung jarak bulan antara tanggal jatuh tempo dan tanggal saat ini dengan periode 1 bulan
            $monthsDifference = (($currentYear - $dueYear) * 12) + ($currentMonth - $dueMonth);

            // Menyimpan jarak bulan ke dalam properti baru
            $tagihanpam->jarak_bulan = $monthsDifference;
        });
        return view('tagihan', compact('tagihanpams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pams = NoPam::all();
        return view('tagihan-create', compact('pams'));
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
            'pam_id' => 'required|exists:no_pams,id',
            'tanggal_tagihan' => 'required|date',
            'due_date' => 'required|date',
            'pemakaian' => 'required|numeric'
        ]);

        $pam = NoPam::findOrFail($request->pam_id);

        // Tentukan harga berdasarkan tipe pam
        $harga = 0; // Default harga
        if ($pam->tipe == 'M1') {
            $harga = (4000 * $request->pemakaian);
        } elseif ($pam->tipe == 'M2') {
            $harga = (5000 * $request->pemakaian);
        } elseif ($pam->tipe == 'M3') {
            $harga = (6000 * $request->pemakaian);
        } else {
            // Tipe pam tidak dikenali, mungkin perlu ditangani sesuai kebutuhan aplikasi Anda
            return redirect()->back()->with('error', 'Tipe pam tidak valid.');
        }

        // Pastikan harga tidak negatif
        if ($harga < 0) {
            return redirect()->back()->with('error', 'Harga tidak valid.');
        }

        $tagihanPam = new Tagihan_Pam([
            'user_id' => $pam->user_id,
            'pam_id' => $pam->id,
            'tanggal_tagihan' => $request->tanggal_tagihan,
            'due_date' => $request->due_date,
            'harga' => $harga,
            'status_pembayaran' => 'belum dibayar',
            'meter_awal' => $pam->meter,
            'meter_akhir' => $pam->meter + $request->pemakaian,
            'pemakaian' => $request->pemakaian
        ]);

        $pam->update([
            'meter' => $tagihanPam->meter_akhir,
        ]);

        $tagihanPam->save();
        return redirect()->route('admin.tagihan.index')->with('success', 'Tagihan Pam created successfully.');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        Tagihan_Pam::find($id)->delete();

        return redirect()->route('admin.tagihan.index')
            ->with('success', 'Pam Success deleted');
    }
}
