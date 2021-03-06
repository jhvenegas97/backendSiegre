<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['midldleware'=>'guest'],function(){
    Route::get('/', function () {
        if(Auth::check()) {
            return redirect('/home');
        } else {
            return view('welcome');
        }
    })->name('welcome');

    // Google login
    Route::get('/login/google', [App\Http\Controllers\Auth\LoginController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleGoogleCallback']);

    Route::post('/checkIdentificationPost',[Controllers\Auth\LoginController::class, 'checkID']);
    Route::get('/checkIdentification', function (){
        return view('auth.checkIdentification');
    })->name('checkIdentification');

    Route::get('/about',function(){return view('about');})->name('about');

    Route::get('/list-curriculum', [Controllers\ListCurriculumController::class, 'index'])->name('list-curriculum');
    Route::get('/curriculum', [Controllers\CurriculumController::class, 'index']);
    Route::get('/publication', [Controllers\PublicationDetailController::class, 'index']);
});

Auth::routes();

Route::group(['middleware'=>'auth'],function(){
    /* Route::get('sendPublicationNotification', function () {
        event(new App\Events\PublicationEvent('$request'));
    }); */

    Route::resource('roles', Controllers\RoleController::class);
    Route::resource('permissions', Controllers\PermissionController::class);

    Route::get('/user', [Controllers\UserController::class, 'index'])->middleware('can:user-list')->name('user');
    Route::post('/add-update-user', [Controllers\UserController::class, 'store'])->middleware('can:user-create,user-update')->name('store-user');
    Route::get('/edit-user', [Controllers\UserController::class, 'edit'])->name('edit-user');
    Route::post('/delete-user', [Controllers\UserController::class, 'destroy']);
    Route::get('user-list-excel',[Controllers\UserController::class, 'exportExcel'])->name('users.excel');

    Route::get('/program', [Controllers\ProgramController::class, 'index'])->name('program');
    Route::post('/add-update-program', [Controllers\ProgramController::class, 'store'])->middleware('role_or_permission:program-create,program-edit');
    Route::post('/edit-program', [Controllers\ProgramController::class, 'edit']);
    Route::post('/delete-program', [Controllers\ProgramController::class, 'destroy']);

    Route::get('/faculty', [Controllers\FacultyController::class, 'index'])->name('faculty');
    Route::post('/add-update-faculty', [Controllers\FacultyController::class, 'store']);
    Route::post('/edit-faculty', [Controllers\FacultyController::class, 'edit']);
    Route::post('/delete-faculty', [Controllers\FacultyController::class, 'destroy']);

    Route::get('/academic', [Controllers\AcademicController::class, 'index'])->name('academic');
    Route::post('/add-update-academic', [Controllers\AcademicController::class, 'store']);
    Route::post('/edit-academic', [Controllers\AcademicController::class, 'edit']);
    Route::post('/delete-academic', [Controllers\AcademicController::class, 'destroy']);

    Route::get('/academic-level', [Controllers\AcademicLevelController::class, 'index'])->name('academic-level');
    Route::post('/add-update-academic-level', [Controllers\AcademicLevelController::class, 'store']);
    Route::post('/edit-academic-level', [Controllers\AcademicLevelController::class, 'edit']);
    Route::post('/delete-academic-level', [Controllers\AcademicLevelController::class, 'destroy']);

    Route::get('/work', [Controllers\WorkController::class, 'index'])->name('work');
    Route::post('/add-update-work', [Controllers\WorkController::class, 'store']);
    Route::post('/edit-work', [Controllers\WorkController::class, 'edit']);
    Route::post('/delete-work', [Controllers\WorkController::class, 'destroy']);

    Route::get('/work-type', [Controllers\WorkTypeController::class, 'index'])->name('work-type');
    Route::post('/add-update-work-type', [Controllers\WorkTypeController::class, 'store']);
    Route::post('/edit-work-type', [Controllers\WorkTypeController::class, 'edit']);
    Route::post('/delete-work-type', [Controllers\WorkTypeController::class, 'destroy']);

    Route::get('/feed', [Controllers\PublicationFeedController::class, 'index'])->name('feed');
    Route::post('/add-update-publication', [Controllers\PublicationFeedController::class, 'store']);
    Route::post('/edit-publication', [Controllers\PublicationFeedController::class, 'edit']);
    Route::post('/delete-publication', [Controllers\PublicationFeedController::class, 'destroy']);

    Route::get('/publications', [Controllers\PublicationFeedController::class, 'indexAdmin'])->name('publications');

    Route::get('/admin', function () {
        return view('admin.admin');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/administrador-listausuario','AdministradorListaUsuarioController@getListaUsuarios');
    Route::get('/administrador-listapublicacion','AdministradorListaPublicacionController@getListaPublicaciones');
});