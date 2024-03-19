<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\MatapelajaranController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\CatController;

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

Route::get('/login-admin', [AuthController::class, 'loginFormAdmin'])->name('login');
Route::get('/login', [AuthController::class, 'loginFormSiswa'])->name('login-siswa');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return redirect('/login')->withErrors(['msg' => 'Please log in to continue your session']);
    }
});

Route::middleware('auth:web')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user', [UserController::class, 'saveOrUpdate'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'saveOrUpdate'])->name('user.update');
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/permission', [PermissionController::class, 'index'])->name('permission');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permission', [PermissionController::class, 'saveOrUpdate'])->name('permission.store');
    Route::put('/permission/{id}', [PermissionController::class, 'saveOrUpdate'])->name('permission.update');
    Route::delete('/permission/delete', [PermissionController::class, 'destroy'])->name('permission.destroy');

    Route::get('/role', [RoleController::class, 'index'])->name('role');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::get('/role/detail/{id}', [RoleController::class, 'detail'])->name('role.detail');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/role', [RoleController::class, 'saveOrUpdate'])->name('role.store');
    Route::post('/role/savePermission', [RoleController::class, 'savePermission'])->name('role.savePermission');
    Route::put('/role/{id}', [RoleController::class, 'saveOrUpdate'])->name('role.update');
    Route::delete('/role/delete', [RoleController::class, 'destroy'])->name('role.destroy');

    // Computer Assisted Test Route
    Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah');
    Route::get('/sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
    Route::get('/sekolah/edit/{id}', [SekolahController::class, 'edit'])->name('sekolah.edit');
    Route::post('/sekolah', [SekolahController::class, 'saveOrUpdate'])->name('sekolah.store');
    Route::put('/sekolah/{id}', [SekolahController::class, 'saveOrUpdate'])->name('sekolah.update');
    Route::delete('/sekolah/delete', [SekolahController::class, 'destroy'])->name('sekolah.destroy');

    Route::get('/matapelajaran', [MatapelajaranController::class, 'index'])->name('matapelajaran');
    Route::get('/matapelajaran/create', [MatapelajaranController::class, 'create'])->name('matapelajaran.create');
    Route::get('/matapelajaran/edit/{id}', [MatapelajaranController::class, 'edit'])->name('matapelajaran.edit');
    Route::post('/matapelajaran', [MatapelajaranController::class, 'saveOrUpdate'])->name('matapelajaran.store');
    Route::put('/matapelajaran/{id}', [MatapelajaranController::class, 'saveOrUpdate'])->name('matapelajaran.update');
    Route::delete('/matapelajaran/delete', [MatapelajaranController::class, 'destroy'])->name('matapelajaran.destroy');


    Route::get('/soal', [SoalController::class, 'index'])->name('soal');
    Route::get('/soal/create', [SoalController::class, 'create'])->name('soal.create');
    Route::get('/soal/edit/{id}', [SoalController::class, 'edit'])->name('soal.edit');
    Route::get('/soal/detail/{id}', [SoalController::class, 'detail'])->name('soal.detail');
    Route::post('/soal', [SoalController::class, 'saveOrUpdate'])->name('soal.store');
    Route::put('/soal/{id}', [SoalController::class, 'saveOrUpdate'])->name('soal.update');
    Route::delete('/soal/delete', [SoalController::class, 'destroy'])->name('soal.destroy');

    Route::get('/soal/{id}/butirsoal/create', [SoalController::class, 'createButirSoal'])->name('soal.butirsoal.create');
    Route::get('/soal/butirsoal/edit/{id}', [SoalController::class, 'editButirSoal'])->name('soal.butirsoal.edit');
    Route::post('/soal/butirsoal/store', [SoalController::class, 'saveOrUpdateButirSoal'])->name('soal.butirsoal.store');
    Route::put('/soal/butirsoal/{id}', [SoalController::class, 'saveOrUpdateButirSoal'])->name('soal.butirsoal.update');
    Route::delete('/soal/butirsoal/delete', [SoalController::class, 'destroyButirSoal'])->name('soal.butirsoal.destroy');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa', [SiswaController::class, 'saveOrUpdate'])->name('siswa.store');
    Route::put('/siswa/{id}', [SiswaController::class, 'saveOrUpdate'])->name('siswa.update');
    Route::delete('/siswa/delete', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::post('/siswa/uploadImportFile', [SiswaController::class, 'uploadImportFile'])->name('siswa.uploadImportFile');
    Route::post('/siswa/getKelas', [SiswaController::class, 'getKelas'])->name('siswa.getKelas');

    Route::get('/cat', [CatController::class, 'index'])->name('cat');
});
