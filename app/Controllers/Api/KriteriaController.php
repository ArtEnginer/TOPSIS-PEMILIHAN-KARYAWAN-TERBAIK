<?php

namespace App\Controllers\Api;

use App\Controllers\BaseApi;
use App\Models\Topsis\KriteriaModel;

class KriteriaController extends BaseApi
{
    protected $modelName = KriteriaModel::class;
    protected $load = ["subkriteria"];

    public function validateCreate(&$request)
    {
        return $this->validate([
            'kode' => 'required',
            'nama' => 'required',
        ]);
    }
}
