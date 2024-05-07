<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(Request $request)
    {

        $limit = $request->query('limit') !== null ? $request->query('limit') : 10;

        $relations = [

            'paymentMethod:id,name,code,thumbnail',
            'transactionType:id,name,code,action,thumbnail'
        ];

        $user = auth()->user();

        $transactions = Transaction::with($relations)
            ->where('user_id', $user->id)
            ->where('status', 'success')
            ->orderBy('id', 'desc')
            ->paginate($limit);

        $transactions->getCollection()->transform(function ($item) {
            // Ambil URL thumbnail metode pembayaran atau kosongkan jika tidak tersedia
            $paymentMethodThumbnail = $item->paymentMethod->thumbnail
                ? url('storage/' . $item->paymentMethod->thumbnail)
                : '';

            // Setel URL thumbnail pada objek metode pembayaran
            $item->paymentMethod->thumbnail = $paymentMethodThumbnail;

            // Ambil URL thumbnail tipe transaksi atau kosongkan jika tidak tersedia
            $transactionTypeThumbnail = $item->transactionType->thumbnail
                ? url('storage/' . $item->transactionType->thumbnail)
                : '';

            // Setel URL thumbnail pada objek tipe transaksi
            $item->transactionType->thumbnail = $transactionTypeThumbnail;

            return $item;
        });

        return response()->json($transactions);
    }
}
