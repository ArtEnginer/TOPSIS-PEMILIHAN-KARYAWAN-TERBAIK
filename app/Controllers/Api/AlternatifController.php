<?php

namespace App\Controllers\Api;

use App\Controllers\BaseApi;
use App\Models\Topsis\AlternatifModel;

class AlternatifController extends BaseApi
{
    protected $modelName = AlternatifModel::class;
    protected $load    = ["penilaian"];
}
