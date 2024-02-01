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
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('change/password', 'changePassword')->name('change/password');
    });

    // ----------------------------- register -------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register','storeUser')->name('register');    
    });
});
Route::middleware(['auth', 'user-role:Administrator'])->group(function()
{
    Route::post('/admin/dashboard', 'App\Http\Controllers\AdminController\DashboardController@index')->name('admin.dashboard');
    Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController\DashboardController@index')->name('admin.dashboard');
    Route::get('/admin/profile', 'App\Http\Controllers\AdminController\ProfileController@index')->name('admin.profile');
    
    Route::controller(App\Http\Controllers\AdminController\StudentController::class)->group(function () {
        Route::get('/admin/modules/student', 'index')->name('admin/student_list');
        Route::get('/admin/modules/student/profile', 'viewProfile')->name('admin/student_profile');
    });
    Route::controller(App\Http\Controllers\AdminController\RecordController::class)->group(function () {
        Route::get('/admin/modules/student/record', 'index')->name('admin/student_record');
        Route::get('/admin/modules/student/view=record', 'viewRecord')->name('admin/view_record');
        Route::post('fetch-record', 'fetchRecord');
    });
    Route::controller(App\Http\Controllers\AdminController\SubjectController::class)->group(function () {
        Route::get('/admin/modules/subject', 'index')->name('admin/subject');
        Route::post('fetch-subject', 'fetchSubjects');
    });
    
});


