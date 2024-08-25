<?php

namespace App\Controllers\Api;

use App\Controllers\BaseApi;
use App\Models\Topsis\HasilModel;
use Ramsey\Uuid\Uuid;

class HasilController extends BaseApi
{
    protected $modelName = HasilModel::class;
    protected $load = ["alternatif"];

    public function validateCreate(&$request)
    {
        return $this->validate([
            'periode' => 'required',
            'alternatif_id' => 'required',
            'nilai' => 'required',
        ]);
    }
    public function save()
    {
        $items = $this->request->getJSON();
        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'id' => Uuid::uuid4(),
                'periode' => $item->periode,
                'alternatif_id' => $item->alternatif_id,
                'nilai' => $item->nilai,
            ];

            HasilModel::where('periode', $item->periode)
                ->where('alternatif_id', $item->alternatif_id)
                ->delete();
        }

        foreach ($data as $key => $value) {
            $this->validateCreate($value);
        }

        HasilModel::insert($data);
        return $this->respond([
            'messages' => [
                'success' => 'Data berhasil disimpan',
            ],
        ]);
    }
}
