<?php

namespace App\Http\Controllers;

use App\Services\WilayahService;
use Illuminate\Http\JsonResponse;

class WilayahController extends Controller
{
    protected WilayahService $wilayah;

    public function __construct(WilayahService $wilayah)
    {
        $this->wilayah = $wilayah;
    }

    public function provinsi(): JsonResponse
    {
        return response()->json($this->wilayah->getProvinsi());
    }

    public function kabupaten($provinsiId): JsonResponse
    {
        return response()->json($this->wilayah->getKabupaten($provinsiId));
    }

    public function kecamatan($kabupatenId): JsonResponse
    {
        return response()->json($this->wilayah->getKecamatan($kabupatenId));
    }

    public function desa($kecamatanId): JsonResponse
    {
        return response()->json($this->wilayah->getDesa($kecamatanId));
    }
}
