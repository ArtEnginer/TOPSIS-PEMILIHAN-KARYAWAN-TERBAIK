<?php

namespace App\Controllers;
use App\Models\Cfhens\RuleModel;

class Home extends BaseController
{
    public function index(): string
    {
        // dd(RuleModel::get()->groupBy('code')->toJson());
        return view('pages/landing/index');
    }
}
