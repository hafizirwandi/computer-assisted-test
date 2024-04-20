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
use App\Http\Controllers\ImportNilaiController;
use App\Http\Controllers\KirimNilaiController;
use App\Http\Controllers\PengaturanUjianController;
use App\Http\Controllers\ResetUjianController;
use App\Http\Controllers\RekapNilaiController;
use App\Http\Controllers\RekapNilaiGlobalController;

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
Route::post('/auth-siswa', [AuthController::class, 'authSiswa'])->name('auth.siswa');
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

    Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('can:user-list');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create')->middleware('can:user-create');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('can:user-edit');
    Route::post('/user', [UserController::class, 'saveOrUpdate'])->name('user.store')->middleware('can:user-create');
    Route::put('/user/{id}', [UserController::class, 'saveOrUpdate'])->name('user.update')->middleware('can:user-edit');
    Route::delete('/user/delete', [UserController::class, 'destroy'])->name('user.destroy')->middleware('can:user-delete');

    Route::get('/permission', [PermissionController::class, 'index'])->name('permission')->middleware('can:permission-list');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('can:permission-create');
    Route::get('/permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('can:permission-edit');
    Route::post('/permission', [PermissionController::class, 'saveOrUpdate'])->name('permission.store')->middleware('can:permission-create');
    Route::put('/permission/{id}', [PermissionController::class, 'saveOrUpdate'])->name('permission.update')->middleware('can:permission-edit');
    Route::delete('/permission/delete', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware('can:permission-delete');

    Route::get('/role', [RoleController::class, 'index'])->name('role')->middleware('can:role-list');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create')->middleware('can:role-create');
    Route::get('/role/detail/{id}', [RoleController::class, 'detail'])->name('role.detail')->middleware('can:role-add-permission');
    Route::get('/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('can:role-edit');
    Route::post('/role', [RoleController::class, 'saveOrUpdate'])->name('role.store')->middleware('can:role-create');
    Route::post('/role/savePermission', [RoleController::class, 'savePermission'])->name('role.savePermission')->middleware('can:role-add-permission');
    Route::put('/role/{id}', [RoleController::class, 'saveOrUpdate'])->name('role.update')->middleware('can:role-edit');
    Route::delete('/role/delete', [RoleController::class, 'destroy'])->name('role.destroy')->middleware('can:role-delete');

    Route::get('/sekolah', [SekolahController::class, 'index'])->name('sekolah')->middleware('can:sekolah-list');
    Route::get('/sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create')->middleware('can:sekolah-create');
    Route::get('/sekolah/edit/{id}', [SekolahController::class, 'edit'])->name('sekolah.edit')->middleware('can:sekolah-edit');
    Route::post('/sekolah', [SekolahController::class, 'saveOrUpdate'])->name('sekolah.store')->middleware('can:sekolah-create');
    Route::put('/sekolah/{id}', [SekolahController::class, 'saveOrUpdate'])->name('sekolah.update')->middleware('can:sekolah-edit');
    Route::delete('/sekolah/delete', [SekolahController::class, 'destroy'])->name('sekolah.destroy')->middleware('can:sekolah-delete');

    Route::get('/matapelajaran', [MatapelajaranController::class, 'index'])->name('matapelajaran')->middleware('can:matapelajaran-list');
    Route::get('/matapelajaran/create', [MatapelajaranController::class, 'create'])->name('matapelajaran.create')->middleware('can:matapelajaran-create');
    Route::get('/matapelajaran/edit/{id}', [MatapelajaranController::class, 'edit'])->name('matapelajaran.edit')->middleware('can:matapelajaran-edit');
    Route::post('/matapelajaran', [MatapelajaranController::class, 'saveOrUpdate'])->name('matapelajaran.store')->middleware('can:matapelajaran-create');
    Route::put('/matapelajaran/{id}', [MatapelajaranController::class, 'saveOrUpdate'])->name('matapelajaran.update')->middleware('can:matapelajaran-edit');
    Route::delete('/matapelajaran/delete', [MatapelajaranController::class, 'destroy'])->name('matapelajaran.destroy')->middleware('can:matapelajaran-delete');


    Route::get('/soal', [SoalController::class, 'index'])->name('soal')->middleware('can:soal-list');
    Route::get('/soal/create', [SoalController::class, 'create'])->name('soal.create')->middleware('can:soal-create');
    Route::get('/soal/edit/{id}', [SoalController::class, 'edit'])->name('soal.edit')->middleware('can:soal-edit');
    Route::get('/soal/detail/{id}', [SoalController::class, 'detail'])->name('soal.detail')->middleware('can:butirsoal-list');
    Route::post('/soal', [SoalController::class, 'saveOrUpdate'])->name('soal.store')->middleware('can:soal-create');
    Route::put('/soal/{id}', [SoalController::class, 'saveOrUpdate'])->name('soal.update')->middleware('can:soal-edit');
    Route::delete('/soal/delete', [SoalController::class, 'destroy'])->name('soal.destroy')->middleware('can:soal-delete');

    Route::get('/soal/{id}/butirsoal/create', [SoalController::class, 'createButirSoal'])->name('soal.butirsoal.create')->middleware('can:butirsoal-create');
    Route::get('/soal/butirsoal/edit/{id}', [SoalController::class, 'editButirSoal'])->name('soal.butirsoal.edit')->middleware('can:butirsoal-edit');
    Route::post('/soal/butirsoal/store', [SoalController::class, 'saveOrUpdateButirSoal'])->name('soal.butirsoal.store')->middleware('can:butirsoal-create');
    Route::put('/soal/butirsoal/{id}', [SoalController::class, 'saveOrUpdateButirSoal'])->name('soal.butirsoal.update')->middleware('can:butirsoal-edit');
    Route::delete('/soal/butirsoal/delete', [SoalController::class, 'destroyButirSoal'])->name('soal.butirsoal.destroy')->middleware('can:butirsoal-delete');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa')->middleware('can:siswa-list');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create')->middleware('can:siswa-create');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit')->middleware('can:siswa-edit');
    Route::post('/siswa', [SiswaController::class, 'saveOrUpdate'])->name('siswa.store')->middleware('can:siswa-create');
    Route::put('/siswa/{id}', [SiswaController::class, 'saveOrUpdate'])->name('siswa.update')->middleware('can:siswa-edit');
    Route::delete('/siswa/delete', [SiswaController::class, 'destroy'])->name('siswa.destroy')->middleware('can:siswa-delete');
    Route::get('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import')->middleware('can:siswa-import');
    Route::post('/siswa/uploadImportFile', [SiswaController::class, 'uploadImportFile'])->name('siswa.uploadImportFile')->middleware('can:siswa-import');
    Route::post('/siswa/getKelas', [SiswaController::class, 'getKelas'])->name('siswa.getKelas');
    Route::post('/siswa/getSiswa', [SiswaController::class, 'getSiswa'])->name('siswa.getSiswa');

    Route::get('/pengaturan-ujian', [PengaturanUjianController::class, 'index'])->name('pengaturan-ujian')->middleware('can:p-ujian-list');
    Route::get('/pengaturan-ujian/create', [PengaturanUjianController::class, 'create'])->name('pengaturan-ujian.create')->middleware('can:p-ujian-create');
    Route::get('/pengaturan-ujian/edit/{id}', [PengaturanUjianController::class, 'edit'])->name('pengaturan-ujian.edit')->middleware('can:p-ujian-edit');
    Route::post('/pengaturan-ujian', [PengaturanUjianController::class, 'saveOrUpdate'])->name('pengaturan-ujian.store')->middleware('can:p-ujian-create');
    Route::put('/pengaturan-ujian/{id}', [PengaturanUjianController::class, 'saveOrUpdate'])->name('pengaturan-ujian.update')->middleware('can:p-ujian-edit');
    Route::delete('/pengaturan-ujian/delete', [PengaturanUjianController::class, 'destroy'])->name('pengaturan-ujian.destroy')->middleware('can:p-ujian-delete');

    Route::get('/ganti-password', [AuthController::class, 'gantiPassword'])->name('ganti-password')->middleware('can:ganti-password');
    Route::post('/ganti-password', [AuthController::class, 'saveGantiPassword'])->name('ganti-password.save')->middleware('can:ganti-password');

    Route::get('/reset-ujian', [ResetUjianController::class, 'index'])->name('reset-ujian')->middleware('can:reset-ujian-list');
    Route::get('/reset-ujian/create', [ResetUjianController::class, 'create'])->name('reset-ujian.create')->middleware('can:reset-ujian-create');
    Route::post('/reset-ujian', [ResetUjianController::class, 'store'])->name('reset-ujian.store')->middleware('can:reset-ujian-create');
    Route::get('/reset-ujian/edit/{id}', [ResetUjianController::class, 'edit'])->name('reset-ujian.edit')->middleware('can:reset-ujian-edit');
    Route::put('/reset-ujian/{id}', [ResetUjianController::class, 'update'])->name('reset-ujian.update')->middleware('can:reset-ujian-edit');
    Route::delete('/reset-ujian/delete', [ResetUjianController::class, 'destroy'])->name('reset-ujian.destroy')->middleware('can:reset-ujian-delete');

    Route::get('/rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap-nilai')->middleware('can:rekap-nilai');
    Route::get('/rekap-nilai/kumulatif', [RekapNilaiController::class, 'kumulatif'])->name('rekap-nilai.kumulatif')->middleware('can:rekap-nilai-kumulatif');
    Route::get('/rekap-nilai/dashboard', [RekapNilaiController::class, 'dashboard'])->name('rekap-nilai.dashboard')->middleware('can:rekap-nilai-dashboard');

    Route::get('/rekap-nilai-global', [RekapNilaiGlobalController::class, 'index'])->name('rekap-nilai-global')->middleware('can:rekap-nilai-global');
    Route::get('/rekap-nilai-global/kumulatif', [RekapNilaiGlobalController::class, 'kumulatif'])->name('rekap-nilai-global.kumulatif')->middleware('can:rekap-nilai-global-kumulatif');
    Route::get('/rekap-nilai-global/dashboard', [RekapNilaiGlobalController::class, 'dashboard'])->name('rekap-nilai-global.dashboard')->middleware('can:rekap-nilai-global-dashboard');

    Route::get('/kirim-nilai', [KirimNilaiController::class, 'index'])->name('kirim-nilai')->middleware('can:sinkronisasi-nilai');
    Route::post('/kirim-nilai/syncData', [KirimNilaiController::class, 'syncData'])->name('kirim-nilai.syncData')->middleware('can:sinkronisasi-nilai');
    Route::get('/kirim-nilai/check-sync-data', [KirimNilaiController::class, 'checkSyncData'])->name('kirim-nilai.checkSyncData')->middleware('can:cek-hasil-sinkronisasi-nilai');
    Route::get('/kirim-nilai/export', [KirimNilaiController::class, 'exportData'])->name('kirim-nilai.export')->middleware('can:eksport-nilai');
    Route::get('/import-nilai', [ImportNilaiController::class, 'index'])->name('import-nilai')->middleware('can:import-nilai');
    Route::post('/import-nilai/upload', [ImportNilaiController::class, 'upload'])->name('import-nilai.upload')->middleware('can:import-nilai');
});

Route::middleware('auth:siswa')->group(function () {
    Route::get('/profile', [SiswaController::class, 'profileSiswa'])->name('profile');
    Route::get('/home-siswa', [HomeController::class, 'siswa'])->name('home.siswa');
    Route::get('/cat', [CatController::class, 'index'])->name('cat');
    Route::post('/cat/check-kode-ujian', [CatController::class, 'checkKodeUjian'])->name('cat.checkKodeUjian');
    Route::get('/cat/mulai/{id}', [CatController::class, 'mulai'])->name('cat.mulai');
    Route::post('/cat/get-soal', [CatController::class, 'getSoal'])->name('cat.getSoal');
    Route::post('/cat/update-jawaban', [CatController::class, 'updateJawaban'])->name('cat.updateJawaban');
    Route::post('/cat/hitung-hasil', [CatController::class, 'hitungHasil'])->name('cat.hitungHasil');
    Route::get('/cat/hasil/{id}', [CatController::class, 'hasil'])->name('cat.hasil');
    Route::get('/cat/nilai', [CatController::class, 'nilai'])->name('cat.nilai');
});
