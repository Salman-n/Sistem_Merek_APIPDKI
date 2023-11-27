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

use App\Http\Controllers\DashboardController;


use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\admin;
Route::get("/",[DashboardController::class , 'index']);

Route::middleware([Admin::class])->prefix('admin')->group(function () {
    Route::get("/",[AdminController::class , 'index']);

    Route::get("/verifikasi",[AdminController::class , 'verifikasi']);
    Route::get("/verifikasi/terima/{id}",[AdminController::class , 'terimaVerifikasi']);
    Route::get("/verifikasi/tolak/{id}",[AdminController::class , 'tolakVerifikasi']);

    Route::get("/permohonan",[AdminController::class , 'permohonan']);
    Route::get("/permohonan/terima/{id}",[AdminController::class , 'terimaPermohonan']);
    Route::get("/permohonan/tolak/{id}",[AdminController::class , 'tolakPermohonan']);
    Route::get("/permohonan/perbaiki/{id}",[AdminController::class , 'perbaikiPermohonan']);

    Route::get("/pemohon",[AdminController::class , 'pemohon']);
    Route::get("/admin",[AdminController::class , 'admin']);
    Route::post("/admin/add",[AdminController::class , 'addAdmin']);
   
    Route::get("/pemohon/delete/{id}",[AdminController::class , 'deletePemohon']);

    Route::get("/pengumuman",[AdminController::class , 'pengumuman']);
    Route::get("/pengumuman/tambah",[AdminController::class , 'tambahPengumuman']);
    Route::post("/pengumuman/tambah",[AdminController::class , 'handleTambahPengumuman'])->name('pengumuman.tambah');;
    Route::get("/pengumuman/delete/{id}",[AdminController::class , 'hapusPengumuman'])->name('pengumuman.tambah');;
   
    Route::get("/infografis",[AdminController::class , 'infografis']);

   Route::post('/logout', [AdminController::class , 'logout'])->name('adminlogout');

});
Route::get('/admin/login', [AdminController::class , 'showLoginForm'])->name('adminlogin');
Route::post('/admin/login', [AdminController::class , 'login']);


Route::get("/permohonan",[DashboardController::class , 'permohonan']);

Route::get("/pengumuman",[PengumumanController::class , 'index']);

Route::get('/register', [RegisterController::class , 'showRegistrationForm'])->name('register');
Route::post('/register',[RegisterController::class , 'register']);

Route::get('/login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class , 'login']);
Route::post('/logout', [DashboardController::class , 'logout'])->name('logout');

Route::get('/tambah', [DashboardController::class , 'showTambahForm'])->name('tambah');
Route::post('/tambah', [DashboardController::class , 'tambah']);

Route::get('/edit/{id}', [DashboardController::class , 'showEditForm']);
Route::post('/edit', [DashboardController::class , 'edit'])->name('edit');

Route::get('/editprofil', [DashboardController::class , 'showProfileEditForm']);
Route::post('/editprofil', [DashboardController::class , 'editprofil'])->name('editprofil');


Route::get('/lihat/{id}', [DashboardController::class , 'showForm']);
