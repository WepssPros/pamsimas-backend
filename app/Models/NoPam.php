<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoPam extends Model
{
    use SoftDeletes;

    protected $table = 'no_pams';

    protected $fillable = [
        'user_id',
        'atas_nama',
        'no_pam',
        'tgl_pemasangan',
        'alamat',
        'tipe',
        'meter',
    ];

    protected $dates = ['deleted_at'];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
