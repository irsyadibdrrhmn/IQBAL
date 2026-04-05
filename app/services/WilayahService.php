<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WilayahService
{
    protected string $baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    public function getProvinsi(): array
    {
        return $this->fetchJson('/provinces.json');
    }

    public function getKabupaten(string $provinsiId): array
    {
        return $this->fetchJson("/regencies/{$provinsiId}.json");
    }

    public function getKecamatan(string $kabupatenId): array
    {
        return $this->fetchJson("/districts/{$kabupatenId}.json");
    }

    public function getDesa(string $kecamatanId): array
    {
        return $this->fetchJson("/villages/{$kecamatanId}.json");
    }

    protected function fetchJson(string $endpoint): array
    {
        try {
            $response = Http::timeout(10)->get("{$this->baseUrl}{$endpoint}");
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            report($e);
        }

        return [];
    }
}
