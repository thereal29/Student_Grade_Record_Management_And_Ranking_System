<?php

namespace App\Http\Controllers\StudentController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $role = auth()->user()->role;
        return view('student.dashboard', compact('role'));
    }
}
