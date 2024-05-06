<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private function generateCardNumber($length = 16)
    {
        // Menghasilkan nomor kartu dengan panjang yang ditentukan
        $cardNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $cardNumber .= rand(0, 9); // Tambahkan angka acak antara 0 dan 9 ke nomor kartu
        }
        return $cardNumber;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $users = User::all();

        return view('user', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usercreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    public function store(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'username' => 'required|string|unique:users,username',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto profil harus berupa file gambar dengan maksimal ukuran 2MB
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // KTP harus berupa file gambar dengan maksimal ukuran 2MB
            'verified' => 'nullable|boolean',
            // 'pin' => 'required|string' // Pastikan bahwa 'pin' harus diisi
        ]);

        // Proses unggah foto profil
        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $profilePictureName = time() . '_' . $profilePicture->getClientOriginalName();
            $profilePicture->move(public_path('profile_pictures'), $profilePictureName); // Simpan foto profil di direktori 'public/profile_pictures'
            $profilePicturePath = 'profile_pictures/' . $profilePictureName; // Path foto profil untuk disimpan ke dalam database
        } else {
            $profilePicturePath = null; // Jika tidak ada file yang diunggah, set path foto profil menjadi null
        }

        // Proses unggah foto KTP
        if ($request->hasFile('ktp')) {
            $ktp = $request->file('ktp');
            $ktpName = time() . '_' . $ktp->getClientOriginalName();
            $ktp->move(public_path('ktp_images'), $ktpName); // Simpan foto KTP di direktori 'public/ktp_images'
            $ktpPath = 'ktp_images/' . $ktpName; // Path foto KTP untuk disimpan ke dalam database
        } else {
            $ktpPath = null; // Jika tidak ada file yang diunggah, set path KTP menjadi null
        }

        // Buat objek user dengan data yang diterima dari request
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'profile_picture' => $profilePicturePath, // Simpan path foto profil ke dalam database
            'ktp' => $ktpPath, // Simpan path foto KTP ke dalam database
            'verified' => $request->verified ?? false,
        ]);

        // Simpan data user ke dalam database
        $user->save();

        // Generate nomor kartu baru
        $cardNumber = $this->generateCardNumber(16);

        // Buat wallet baru untuk pengguna
        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0,
            'pin' => "123456",
            'card_number' => $cardNumber
        ]);

        // Redirect ke halaman daftar pengguna
        return redirect()->route('admin.users.index')->with('success', 'User successfully created.');
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
    public function destroy($id)
    {
        //
    }
}
