<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Http\Request;
use App\Models\CoCurricularType;
use App\Models\CoCurricularSubType;
use App\Models\CoCurricularAwardScope;
use App\Models\SchoolYear;
use App\Models\FacultyStaff;

use Illuminate\Support\Facades\View;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        /**
     * Constructor.
     *
     * @param \Illuminate\Http\Request  $request
     */
    public function __construct()
    {
        
        $types = CoCurricularType::all();
        view()->share('categories', $types);
        $sy = SchoolYear::select('*')->groupBy('school_year.from_year')->get();
        
        $currSY = SchoolYear::select('*')->where('isCurrent', 1)->first();
        View::share('sy', $sy);
        View::share('currSY', $currSY);
        $list_faculty = FacultyStaff::select('*', 'faculty_staff_personal_details.id as fid')->join('faculty_staff_user_mapping', 'faculty_staff_user_mapping.faculty_staff_id', '=', 'faculty_staff_personal_details.id')->join('users', 'users.id', '=', 'faculty_staff_user_mapping.user_id')->where('role', '5')->get();
        View::share('list_faculty', $list_faculty);
    }

}
