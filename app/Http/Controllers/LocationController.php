<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected function loadJson()
    {
        // file ở storage (đã copy ở bước trên)
        $path = storage_path('app/data/locations.json');
        if (!file_exists($path)) {
            return null;
        }
        $json = file_get_contents($path);
        return json_decode($json, true);
    }

    public function provinces()
    {
        $data = $this->loadJson();
        if (!$data) return response()->json([], 200);
        // assuming JSON structured: [ { id, name, districts: [ { id, name, wards: [...] } ] }, ... ]
        $provinces = array_map(fn($p) => ['id' => $p['id'], 'name' => $p['name']], $data);
        return response()->json($provinces);
    }

    public function districts($provinceId)
    {
        $data = $this->loadJson();
        if (!$data) return response()->json([], 200);
        $province = collect($data)->first(fn($p) => (string)$p['id'] === (string)$provinceId);
        if (!$province) return response()->json([], 200);
        $districts = array_map(fn($d) => ['id' => $d['id'], 'name' => $d['name']], $province['districts'] ?? []);
        return response()->json($districts);
    }

    public function wards($districtId)
    {
        $data = $this->loadJson();
        if (!$data) return response()->json([], 200);
        // find district in any province
        foreach ($data as $prov) {
            foreach (($prov['districts'] ?? []) as $d) {
                if ((string)$d['id'] === (string)$districtId) {
                    $wards = array_map(fn($w) => ['id' => $w['id'], 'name' => $w['name']], $d['wards'] ?? []);
                    return response()->json($wards);
                }
            }
        }
        return response()->json([], 200);
    }
}
