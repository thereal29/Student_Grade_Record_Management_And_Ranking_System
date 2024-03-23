<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // ----------------------------login ------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login/index', 'login')->name('login');
        Route::post('/login/index', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('change/password', 'changePassword')->name('change/password');
    });
});

// ROUTES FOR SYSTEM ADMINISTRATOR
Route::middleware(['auth', 'user-role:Super Administrator,Administrator'])->group(function()
{
    Route::post('/admin/dashboard', 'App\Http\Controllers\AdminController\DashboardController@index')->name('admin.dashboard');
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController\DashboardController@index')->name('admin.dashboard');
    Route::get('/admin/profile', 'App\Http\Controllers\AdminController\ProfileController@index')->name('admin.profile');
    
    Route::controller(App\Http\Controllers\AdminController\StudentController::class)->group(function () {
        Route::get('/admin/modules/student', 'index')->name('admin/student_list');
        Route::get('/admin/modules/student/profile', 'viewProfile')->name('admin/student_profile');
        Route::post('fetch-students', 'fetchStudents');
    });
    Route::controller(App\Http\Controllers\AdminController\RecordController::class)->group(function () {
        Route::get('/admin/modules/student/record', 'index')->name('admin/student_record');
        Route::get('/admin/modules/student/view=record', 'viewRecord')->name('admin/view_record');
        Route::post('fetch-record', 'fetchRecord');
    });
    Route::controller(App\Http\Controllers\AdminController\ClassController::class)->group(function () {
        Route::get('/admin/modules/class', 'index')->name('admin/class_list');
        Route::post('fetch-subject', 'fetchSubjects');
        Route::delete('delete-subject', 'delete')->name('deleteSubject');
        Route::get('edit-subject', 'edit')->name('editSubject');
        Route::post('update-subject', 'update')->name('updateSubject');
        Route::post('add-subject', 'store')->name('addSubject');
    });
    Route::controller(App\Http\Controllers\AdminController\ClassAdvisoryController::class)->group(function () {
        Route::get('/admin/modules/class_advisory', 'index')->name('admin/class_advisory_list');
        Route::post('fetch-section', 'fetchSection');
        Route::delete('delete-section', 'delete')->name('deleteSection');
        Route::get('edit-section', 'edit')->name('editSection');
        Route::post('update-section', 'update')->name('updateSection');
        Route::post('add-section', 'store')->name('addSection');
    });
    Route::controller(App\Http\Controllers\AdminController\StudentRegistrationController::class)->group(function () {
        Route::get('/admin/modules/student/subject', 'index')->name('admin/student_subject');
        Route::post('fetch-student-registration', 'fetchStudentRegistration');
        Route::get('/admin/modules/student/view=subject', 'viewStudentSubjects')->name('admin/view_subject');
    });
    Route::controller(App\Http\Controllers\AdminController\EvaluationController::class)->group(function () {
        Route::get('/admin/modules/character_evaluation', 'maincontent')->name('admin.character_evaluation');
        Route::get('fetch-character-evaluation', 'fetchEvaluation');
        Route::post('add-character-evaluation', 'addEval')->name('addEvaluation');
        Route::get('/admin/modules/character_evaluation/manage', 'manageQ')->name('admin.manage-character_evaluation');
        
        Route::get('/admin/modules/character_evaluation/results', 'resultsIndex')->name('admin.results-character_evaluation');
        Route::post('fetch-character-evaluation-questions', 'fetchQuestions');
        Route::post('add-character-evaluation-questions', 'addQuestion')->name('addQuestions');
        Route::get('edit-question', 'edit')->name('editQuestions');
        Route::delete('delete-question', 'delete')->name('deleteQuestion');
        Route::delete('delete-evaluation', 'deleteEval')->name('deleteEvaluation');
        Route::post('question-sortable', 'sort');
        Route::post('fetch-character-evaluation-result', 'fetchResults');
    });
    Route::controller(App\Http\Controllers\AdminController\FacultyController::class)->group(function () {
        Route::get('/admin/modules/faculty', 'index')->name('admin/faculty');
        Route::get('/admin/modules/view=faculty', 'viewFacData')->name('admin/view_faculty');
        Route::get('/admin/modules/faculty/view=class', 'viewClass')->name('admin/view_class');
    });
    Route::controller(App\Http\Controllers\AdminController\SchoolYearController::class)->group(function () {
        Route::get('/admin/modules/school_year/index', 'index')->name('admin.school_year');
        Route::get('fetch-school_year', 'fetchSY');
        Route::delete('deleteSY', 'delete')->name('deleteSY');
        Route::get('edit', 'edit')->name('editSY');
        Route::post('add-school_year', 'store');
    });
    Route::controller(App\Http\Controllers\AdminController\UserStudentController::class)->group(function () {
        Route::get('/admin/modules/users/student', 'index')->name('admin.student-user');
        Route::post('fetch-student-user', 'fetchUser');
        Route::get('/admin/modules/users/student/view=add', 'add')->name('admin.student-user-add');
        Route::post('add-student-user', 'create')->name('admin.student-user-create');
        Route::get('edit-student-user', 'edit')->name('editStudentUser');
        Route::post('update-student-user', 'update')->name('updateStudentUser');
    });
    Route::get('getSection/{gradelevel}', function ($gradelevel) {
        $gradelevels = App\Models\GradeSection::where('grade_level',$gradelevel)->get();
        return response()->json($gradelevels);
    });
    Route::controller(App\Http\Controllers\AdminController\UserFacultyController::class)->group(function () {
        Route::get('/admin/modules/users/faculty', 'index')->name('admin.faculty-user');
        Route::post('fetch-faculty-user', 'fetchUser');
        Route::get('/admin/modules/users/faculty/view=add', 'add')->name('admin.faculty-user-add');
        Route::post('add-faculty-user', 'create')->name('admin.faculty-user-create');
        Route::get('edit-faculty-user', 'edit')->name('editFacultyUser');
        Route::post('update-faculty-user', 'update')->name('updateFacultyUser');
    });
    Route::controller(App\Http\Controllers\AdminController\UserStaffController::class)->group(function () {
        Route::get('/admin/modules/users/staff', 'index')->name('admin.staff-user');
        Route::post('fetch-staff-user', 'fetchUser');
        Route::get('/admin/modules/users/staff/view=add', 'add')->name('admin.staff-user-add');
        Route::post('add-staff-user', 'create')->name('admin.staff-user-create');
        Route::get('edit-staff-user', 'edit')->name('editStaffUser');
        Route::post('update-staff-user', 'update')->name('updateStaffUser');
    });
    Route::controller(App\Http\Controllers\AdminController\ValidationController::class)->group(function () {
        Route::get('/admin/modules/validation/grades', 'grades_index')->name('admin.validation.grades');
        Route::get('/admin/modules/validation/co_curricular_activity', 'co_curricular_activity_index')->name('admin.validation.co_curricular_activity');
        Route::post('fetch-validation-grades', 'fetchStudentGrades');
        Route::get('fetch-view-validation-grades', 'fetchViewGradesValidation');
        Route::get('fetch-view-validated-grades', 'fetchViewGradesValidation');
        Route::post('validate-grades', 'validateGrades')->name('validateGrades');
    });
    Route::controller(App\Http\Controllers\AdminController\CoCurricularController::class)->group(function () {
        Route::post('fetch-validation-activity', 'fetchActivity');
        Route::get('view-validation-activity/{id}', 'show')->name('view-validation-activity');
        Route::post('validate-activity', 'validateActivity')->name('validateActivities');
        Route::post('revert-activity', 'revertActivity')->name('revertActivities');
    });
    
});

// ROUTES FOR SYSTEM STAFF
Route::middleware(['auth', 'user-role:Honors and Awards Committee,Guidance Facilitator'])->group(function()
{
    Route::post('/staff/dashboard', 'App\Http\Controllers\StaffController\DashboardController@index')->name('staff.dashboard');
    Route::get('/staff/dashboard', 'App\Http\Controllers\StaffController\DashboardController@index')->name('staff.dashboard');
    Route::get('/staff/profile', 'App\Http\Controllers\StaffController\ProfileController@index')->name('staff.profile');
    Route::controller(App\Http\Controllers\StaffController\ValidationController::class)->group(function () {
        Route::get('/staff/modules/validation/co_curricular_activity', 'index')->name('staff.validation.co_curricular_activity');
        Route::post('fetch-staff-validation-activity', 'fetchActivity');
        Route::get('view-staff-validation-activity/{id}', 'show')->name('view-staff-validation-activity');
        Route::post('validate-staff-activity', 'validateActivity')->name('staffValidateActivities');
        Route::post('revert-staff-activity', 'revertActivity')->name('staffRevertActivities');
    });
    Route::controller(App\Http\Controllers\StaffController\StudentController::class)->group(function () {
        Route::get('/staff/modules/student', 'index')->name('staff/student_list');
        Route::get('/staff/modules/student/profile', 'viewProfile')->name('staff/student_profile');
        Route::post('fetch-staff-students', 'fetchStudents');
        Route::get('/staff/modules/student/view=record', 'viewRecord')->name('staff/view_record');
        Route::post('fetch-staff-record', 'fetchRecord');
    });
    Route::controller(App\Http\Controllers\StaffController\EvaluationController::class)->group(function () {
        Route::get('/staff/modules/character_evaluation', 'maincontent')->name('staff.character_evaluation');
        Route::get('fetch-staff-character-evaluation', 'fetchEvaluation');
        Route::post('add-staff-character-evaluation', 'addEval')->name('staffAddEvaluation');
        Route::get('/staff/modules/character_evaluation/manage', 'manageQ')->name('staff.manage-character_evaluation');
        Route::get('/staff/modules/character_evaluation/results', 'resultsIndex')->name('staff.results-character_evaluation');
        Route::post('fetch-staff-character-evaluation-questions', 'fetchQuestions');
        Route::post('add-staff-character-evaluation-questions', 'addQuestion')->name('staffAddQuestions');
        Route::get('edit-staff-question', 'edit')->name('staffEditQuestions');
        Route::delete('delete-staff-question', 'delete')->name('staffDeleteQuestion');
        Route::delete('delete-staff-evaluation', 'deleteEval')->name('staffDeleteEvaluation');
        Route::post('question-staff-sortable', 'sort');
        Route::get('check-staff-evaluation', 'checkEval')->name('checkEvaluation');
    });
});

// ROUTES FOR TEACHERS(ADVISER/SUBJECT TEACHER)
Route::middleware(['auth', 'user-role:Faculty'])->group(function()
{
    Route::post('/faculty/dashboard', 'App\Http\Controllers\TeacherController\DashboardController@index')->name('faculty.dashboard');
    Route::get('/faculty/dashboard', 'App\Http\Controllers\TeacherController\DashboardController@index')->name('faculty.dashboard');
    Route::get('/faculty/profile', 'App\Http\Controllers\TeacherController\ProfileController@index')->name('faculty.profile');
    Route::controller(App\Http\Controllers\TeacherController\TeacherPortalController::class)->group(function () {
        Route::get('/faculty/portal', 'maincontent')->name('admin.teacher-portal');
        Route::get('fetch-faculty-class', 'fetchClass')->name('fetchClass');
        Route::get('fetch-faculty-advisees', 'fetchAdvisees')->name('fetchAdvisees');
        Route::get('fetch-faculty-grades', 'fetchGrades')->name('fetchGrades');
        Route::get('fetch-faculty-view-class', 'fetchViewClass')->name('fetchViewClass');
        Route::get('fetch-faculty-input-grades', 'fetchInputGrades')->name('fetchInputGrades');
        Route::get('fetch-faculty-view-grades', 'fetchInputGrades')->name('fetchViewGrades');
        Route::get('fetch-view-advisees', 'fetchViewAdvisees')->name('fetchViewAdvisees');
        Route::post('submit-grades', 'submitGrades')->name('submitGrades');
    });
    Route::controller(App\Http\Controllers\TeacherController\PrintableDocumentController::class)->group(function () {
        Route::get('/faculty/class/pdf/{id}', 'generateClassPDF')->name('class.pdf');
        Route::get('/faculty/advisees/pdf/{id}', 'generateAdviseesPDF')->name('advisees.pdf');
    });
    Route::controller(App\Http\Controllers\TeacherController\ExportController::class)->group(function () {
        Route::get('/export-class/{id}', 'exportClassExcel')->name('class.excel');
    });
});

// ROUTES FOR STUDENT USERS
Route::middleware(['auth', 'user-role:Junior High School Student,Senior High School Student'])->group(function()
{
    Route::get('/student/dashboard', 'App\Http\Controllers\StudentController\DashboardController@index')->name('student.dashboard');
    Route::get('/student/profile', 'App\Http\Controllers\StudentController\ProfileController@index')->name('student.profile');
    

    Route::controller(App\Http\Controllers\StudentController\GradesController::class)->group(function () {
        Route::get('/student/modules/grades', 'index')->name('student.grades');
        Route::post('fetch-grades', 'fetchGrades');
    });
    Route::controller(App\Http\Controllers\StudentController\EvaluationController::class)->group(function () {
        Route::get('/student/modules/character_evaluation', 'maincontent')->name('student.character_evaluation');
        Route::post('fetch-student-character-evaluation-questions', 'fetchQuestions');
    });

    Route::controller(App\Http\Controllers\StudentController\CoCurricularController::class)->group(function () {
        Route::get('/student/modules/co_curricular_activity', 'index')->name('student.co_curricular_activity');
        Route::post('fetch-activity', 'fetchActivity');
        Route::post('submit-activity', 'submitActivity')->name('submitActivities');
        Route::delete('delete', 'delete')->name('deleteActivity');
        Route::post('add-activity', 'store');
        Route::get('edit-activity', 'edit')->name('editActivity');
        Route::get('view-activity/{id}', 'show')->name('view-activity');
    });
    Route::get('getSubtypes/{id}', function ($id) {
      $subtypes = App\Models\CoCurricularSubType::where('parentID',$id)->get();
      return response()->json($subtypes);
    });
    Route::get('getAwardScope/{id}', function ($id) {
      $awardscopes = App\Models\CoCurricularAwardScope::where('parentID',$id)->get();
      return response()->json($awardscopes);
    });
});


