<?php

namespace App\Http\Controllers;

use App\Services\OwnerService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OwnerRequest;

class OwnerController extends Controller
{
    public $ownerService;

    public function __construct() {
        $this->ownerService = app(OwnerService::class);
    }

    public function create(OwnerRequest $request)
    {
        $result = [
            'status' => 200
        ];

        try {
            $result['data'] = $this->ownerService->saveUser($request->all());
        }  catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        } 

        return response()->json($result);
    }

    public function login(LoginRequest $request)
    {
        $result = [
            'status' => 200
        ];

        try {
            $result['data'] = $this->ownerService->check($request->all());
        }  catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        } 

        return response()->json($result);
    }
}
