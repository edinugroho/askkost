<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KostService;
use App\Services\UserService;
use App\Services\OwnerService;
use App\Http\Requests\KostRequest;
use App\Http\Requests\FacilityKostRequest;

class KostController extends Controller
{
    public function __construct() {
        $this->ownerService = app(OwnerService::class);
        $this->kostService = app(KostService::class);
        $this->userService = app(UserService::class);
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

    public function update(KostRequest $request, $id)
    {
        $result = [
            'status' => 200
        ];

        try {
            $request->merge(['owner_id' => $request->user()->id]);
            $result['data'] = $this->ownerService->updateKost($request->all(), $id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    public function destroy(Request $request, $id)
    {
        $result = [
            'status' => 200
        ];

        try {
            $result['data'] = $this->ownerService->deleteKost($request->user()->id, $id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    public function detail(FacilityKostRequest $request, $id)
    {
        $result = [
            'status' => 200
        ];

        try {
            $request->merge(['kost_id' => $id]);
            $request->merge(['owner_id' => $request->user()->id]);
            $result['data'] = $this->ownerService->facilityKost($request->all(), $id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    public function index()
    {
        $result = [
            'status' => 200
        ];

        try {;
            $result['data'] = $this->kostService->all();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    public function index_owner(Request $request)
    {
        $result = [
            'status' => 200
        ];

        try {;
            $result['data'] = $this->kostService->byOwner($request->user()->id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }

    public function ask(Request $request, $id)
    {
        $result = [
            'status' => 200
        ];

        try {
            $request->merge(['kost_id' => $id]);
            $request->merge(['user_id' => $request->user()->id]);
            $result['data'] = $this->userService->ask($request->all());
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
}
