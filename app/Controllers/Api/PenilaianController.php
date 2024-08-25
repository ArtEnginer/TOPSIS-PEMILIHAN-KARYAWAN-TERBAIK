<?php

namespace App\Controllers\Api;

use App\Controllers\BaseApi;
use App\Models\Topsis\PenilaianModel;
use Ramsey\Uuid\Uuid;

class PenilaianController extends BaseApi
{
    protected $modelName = PenilaianModel::class;
    protected $load = ["alternatif", "kriteria", "subkriteria"];

    public function validateCreate(&$request)
    {
        return $this->validate([
            'alternatif_id' => 'required|uuid',
            'kriteria_id' => 'required|uuid',
            'subkriteria_id' => 'required|uuid',
            'periode' => 'required|valid_date',
        ]);
    }

    public function save()
    {
        $items = $this->request->getJSON();
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'id' => Uuid::uuid4(),
                'alternatif_id' => $item->alternatif_id,
                'kriteria_id' => $item->kriteria_id,
                'subkriteria_id' => $item->subkriteria_id,
                'periode' => $item->periode,
            ];
            PenilaianModel::where('alternatif_id', $item->alternatif_id)
                ->where('kriteria_id', $item->kriteria_id)
                ->where('periode', $item->periode)
                ->delete();
        }

        foreach ($data as $key => $value) {
            $this->validateCreate($value);
        }

        PenilaianModel::insert($data);
        return $this->respond([
            'messages' => [
                'success' => 'Data berhasil disimpan',
            ],
        ]);
    }
}
