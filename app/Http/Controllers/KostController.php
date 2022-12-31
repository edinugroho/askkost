<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacilityKostRequest;
use Illuminate\Http\Request;
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
}
