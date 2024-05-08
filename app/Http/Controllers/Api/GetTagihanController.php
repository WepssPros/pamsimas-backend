<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NoPam;
use App\Models\Tagihan_Pam;
use Illuminate\Http\Request;

class GetTagihanController extends Controller
{
    public function index(Request $request)
    {

        $limit = $request->query('limit') !== null ? $request->query('limit') : 10;



        $user = auth()->user();
        $nopam = NoPam::where('user_id', $user->id);
        $tagihanPams = Tagihan_Pam::with($user)
            ->where('user_id', $user->id)
            ->where('pam_id', $nopam->id)
            ->latest()
            ->paginate($limit);




        return response()->json($tagihanPams);
    }
}
