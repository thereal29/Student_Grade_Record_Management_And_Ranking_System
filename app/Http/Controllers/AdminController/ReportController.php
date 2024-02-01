<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function maincontent(){
        return view('admin.modules.honor_roll_report.index', ["msg"=>"This is report page"]);
    }
}

