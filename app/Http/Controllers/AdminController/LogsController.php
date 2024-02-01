<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function maincontent(){
        return view('admin.user_logs', ["mssg"=>"This is report page"]);
    }
}
