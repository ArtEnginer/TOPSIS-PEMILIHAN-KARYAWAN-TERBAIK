<?php

namespace App\Controllers\Api;

use App\Controllers\BaseApi;
use App\Models\Topsis\SubKriteriaModel;

class SubKriteriaController extends BaseApi
{
    protected $modelName = SubKriteriaModel::class;

    public function validateCreate(&$request)
    {
        return $this->validate([
            'kode' => 'required',
            'nama' => 'required',
            'value' => 'required',
            'kriteria_id' => 'required',
        ]);
    }
}
