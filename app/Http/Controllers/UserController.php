<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Exception;

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
}
