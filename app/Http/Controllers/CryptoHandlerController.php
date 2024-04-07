<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NooraniMm\EncoderAlgorithm\CryptoHandler;

class CryptoHandlerController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate(['content' => 'required|string',
            'button' => 'required|string']);
        $message = '';
        $result  = '';
        $success = true;
        try {
            if ($request->input('button') === 'decode') {
                $result = CryptoHandler::Decrypt($request->input('content'));
            }
            else {
                $result = CryptoHandler::Encrypt($request->input('content'));
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        $data = [
            'result' => $result,
            'message' => $message,
            'success' => $success,
        ];


        return view('app', $data);
    }
}
