<?php

namespace App\Http\Controllers;

use App\Services\OwnerService;
use App\Http\Requests\KostRequest;

class KostController extends Controller
{
    public function __construct() {
        $this->ownerService = app(OwnerService::class);
    }

    public function create(KostRequest $request)
    {
        $result = [
            'status' => 200
        ];

        try {
            $request->merge(['owner_id' => $request->user()->id]);
            $result['data'] = $this->ownerService->saveKost($request->all());
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
}
