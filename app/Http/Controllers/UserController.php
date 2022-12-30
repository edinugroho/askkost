<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $userService;

    public function __construct() {
        $this->userService = app(UserService::class);
    }

    public function create(UserRequest $request)
    {
        $result = [
            'status' => 200
        ];

        try {
            $result['data'] = $this->userService->saveUser($request->all());
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
            $result['data'] = $this->userService->check($request->all());
        }  catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        } 

        return response()->json($result);
    }

    public function index(Request $request)
    {
        $result = [
            'status' => 200
        ];

        try {
            $result['data'] = $request->user();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
}
