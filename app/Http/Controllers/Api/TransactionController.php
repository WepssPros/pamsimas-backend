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
                ? $item->paymentMethod->thumbnail
                : '';


            if ($paymentMethodThumbnail) {
                $item->paymentMethod->thumbnail = strpos($paymentMethodThumbnail, 'http') === 0
                    ? $paymentMethodThumbnail
                    : url('storage/' . $paymentMethodThumbnail);
            }


            $transactionTypeThumbnail = $item->transactionType->thumbnail
                ? $item->transactionType->thumbnail
                : '';


            if ($transactionTypeThumbnail) {
                $item->transactionType->thumbnail = strpos($transactionTypeThumbnail, 'http') === 0
                    ? $transactionTypeThumbnail
                    : url('storage/' . $transactionTypeThumbnail);
            }

            return $item;
        });


        return response()->json($transactions);
    }
}
