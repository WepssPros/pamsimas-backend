<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Tagihan_Pam;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\TransferHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PembayaranTagihanController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tagihan_pam_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $userId = auth()->user()->id;

        $transactionType = TransactionType::where('code', 'pembayaran')->first();

        $paymentMethod = PaymentMethod::where('code', 'bwa')->first();

        $userWallet = Wallet::where('user_id', $userId)->first();

        $tagihanPam = Tagihan_Pam::where([
            'user_id' => $userId
        ])->find($request->tagihan_pam_id);

        if (!$tagihanPam) {
            return response()->json(['message' => 'Data plan not found'], 404);
        }

     

        if ($userWallet->balance < $tagihanPam->harga) {
            return response()->json(['message' => 'Your balance is not enough'], 400);
        }

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'user_id' => $userId,
                'transaction_type_id' => $transactionType->id,
                'payment_method_id' => $paymentMethod->id,
                'amount' => $tagihanPam->harga,
                'transaction_code' => strtoupper(Str::random(10)),
                'description' => 'Pembayaran Tagihan ' . $tagihanPam->noPam->no_pam,
                'status' => 'success',
            ]);

            $tagihanPam->update([
                'status_pembayaran' => "sudah dibayar"
            ]);


            $userWallet->decrement('balance', $tagihanPam->harga);

            DB::commit();
            return response(['message' => 'Pembayaran Tagihan Pam Success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
