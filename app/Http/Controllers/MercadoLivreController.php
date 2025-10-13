<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class MercadoLivreController extends Controller
{
    #[NoReturn] public function weebhook(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->all());
    }
    #[NoReturn] public function success(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->all());
    }

    // failure
    #[NoReturn] public function failure(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->all());
    }
    // pending
    #[NoReturn] public function pending(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->all());
    }

}
