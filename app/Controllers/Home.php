<?php

namespace App\Controllers;

use App\Models\Cfhens\RuleModel;

class Home extends BaseController
{
    public function index()
    {
        // dd(RuleModel::get()->groupBy('code')->toJson());
        // return view('pages/landing/index');
        // return route to login
        return redirect()->to(route_to('login'));
    }
}
