<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Tagihan_Pam;
use App\Models\TransactionType;
use App\Models\TransferHistory;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PembayaranTagihanController extends Controller
{
    private $paymentMethod;

    private $transactionCode;

    public function __construct()
    {
        $this->paymentMethod = PaymentMethod::where('code', 'bwa')->first();

        $this->transactionCode = strtoupper(Str::random(10));
    }

    public function store(Request $request)
    {
        $data = $request->only('amount', 'pin', 'send_to');

        $validator = Validator::make($data, [
            'amount' => 'required|integer|min:1000',
            'pin' => 'required|digits:6',
            'tagihanpam_id' => 'required'
        ]);

        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 400);
        }

        $sender = auth()->user();
        $paymentMethod = PaymentMethod::where('code', 'bwa')->first();
        $tagihanPam = Tagihan_Pam::where('user_id', $sender->id)->latest();

        #
        $pinChecker = pinChecker($request->pin);
        if (!$pinChecker) {
            return response()->json(['message' => 'Your PIN is wrong'], 400);
        }

        $senderWallet = Wallet::where('user_id', $sender->id)->first();

        if ($senderWallet->balance < $request->amount) {
            return response()->json(['message' => 'Saldo Anda Tidak Cukup'], 400);
        }

        if ($senderWallet->balance < $tagihanPam->harga) {
            return response()->json(['message' => 'Saldo Anda Tidak Cukup'], 400);
        }

        DB::beginTransaction();
        try {

            // Fetch transaction types
            $transactionTypes = TransactionType::whereIn('code', ['pembayaran',])
                ->orderBy('code', 'asc')
                ->get();


            $tagihanPam->update([
                'status_pembayaran' => 'sudah dibayar '
            ]);
            // Check if transaction types exist
            if ($transactionTypes->isEmpty()) {
                throw new \Exception('Transaction types not found.');
            }

            // Get the first and last transaction type

            $transferTransactionType = $transactionTypes->where('code', 'pembayaran')->first();

            // Ensure sender and receiver exist
            if (!$sender) {
                throw new \Exception('Sender or receiver not found.');
            }

            // Create transaction for transfer
            $transferTransaction = $this->createTransaction([
                'user_id' => $sender->id,
                'transaction_type_id' => $transferTransactionType->id,
                'description' => 'Pembayaran Pam ',
                'amount' => $request->amount
            ]);

            // Deduct balance from sender wallet
            $senderWallet->decrement('balance', $request->amount);

            // Record transfer history
            TransferHistory::create([
                'sender_id' => $sender->id,
                'receiver_id' => $sender->id,
                'transaction_code' => $this->transactionCode
            ]);

            // Commit transaction
            DB::commit();
            return response(['message' => 'Transfer Success']);
        } catch (\Throwable $th) {
            // Rollback transaction on error
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
