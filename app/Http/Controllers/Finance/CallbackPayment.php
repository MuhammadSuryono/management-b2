<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Pembayaran_interviewer;
use App\Pembayaran_tl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CallbackPayment extends Controller
{
    public function callback(Request $request)
    {
        try {
            $data = $request->all();
            $body = null;
            foreach($data as $key => $value) {
                $body = json_decode($key);
            }
            $data = $body->data;
            $typePaymentExplode = explode("|", $data->id_rtp_application);
            $typePayment = $typePaymentExplode[1];
            $projectTeamId = $typePaymentExplode[0];

            if ($typePayment == 'interviewer') {
                Log::info('Callback Payment Interviewer ' . $projectTeamId);
                Log::info('Callback Payment Interviewer ' . $data->noid);
                $pembayaranInterveiwer = Pembayaran_interviewer::where("team_id", $projectTeamId)->where("bpu_noid", $data->noid)->first();
                if ($pembayaranInterveiwer) {
                    $pembayaranInterveiwer->status_pembayaran_id = 3;
                    $pembayaranInterveiwer->total_dibayarkan = $data->jumlahbayar;
                    $pembayaranInterveiwer->save();
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Data pembayaran interviewer tidak ditemukan']);
                }
            }

            if ($typePayment == 'tl') {
                $pembayaranInterveiwer = Pembayaran_tl::where("project_team_id", $projectTeamId)->where("bpu_noid", $data->noid)->first();
                if ($pembayaranInterveiwer) {
                    $pembayaranInterveiwer->status_pembayaran_id = 3;
                    $pembayaranInterveiwer->total_dibayarkan = $data->jumlahbayar;
                    $pembayaranInterveiwer->save();
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Data pembayaran TL tidak ditemukan']);
                }
            }
            return response()->json(['status' => 'success', 'data' => $typePayment]);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json(['status' => 'error', 'data' => $e->getMessage()]);
        }
    }
}
