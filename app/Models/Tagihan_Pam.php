<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan_Pam extends Model
{
    use SoftDeletes;

    protected $table = 'tagihan__pams'; // Perhatikan penamaan tabel yang digunakan

    protected $fillable = [
        'user_id',
        'pam_id',
        'tanggal_tagihan',
        'harga',
        'due_date',
        'status_pembayaran',
        'meter_awal',
        'meter_akhir',
        'pemakaian'
    ];

    protected $dates = ['deleted_at'];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model NoPam
    public function noPam()
    {
        return $this->belongsTo(NoPam::class, 'pam_id');
    }
}
