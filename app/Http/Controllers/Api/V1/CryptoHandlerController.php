<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ContentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use NooraniMm\EncoderAlgorithm\CryptoHandler;

class CryptoHandlerController extends Controller
{
    public function encrypt(ContentRequest $request): JsonResponse
    {
        $encoded = CryptoHandler::Encrypt($request->content);

        return $this->success("encoded successfully!", [
            'encoded' => $encoded
        ]);
    }

    public function decrypt(ContentRequest $request): JsonResponse
    {
        try {
            $decoded = CryptoHandler::Decrypt($request->content);

            return $this->success('decoded successfully!', [
                'decoded' => $decoded
            ]);
        } catch (\InvalidArgumentException $e) {
            return $this->errors($e->getMessage(), status: 422);
        } catch (\Exception $e) {
            return $this->errors($e->getMessage(), status: 500);
        }
    }
}
