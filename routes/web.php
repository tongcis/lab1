<?php

use App\Http\Controllers\CheckRoomController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ProfileController as ControllersProfileController;
use App\Http\Controllers\RoomApplicationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\TypeOfRoomController;
use App\Http\Controllers\User\ComplaintUserController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\InventoryController as UserInventoryController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RoomApplicationUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/404', function () {
    return view('pages.auth.404');
})->name('404');


Auth::routes();

Route::get('check', [CheckRoomController::class, 'check'])->name('check');

Route::middleware('auth')->group(function () {
    Route::get('/reset-password/{id}', [UserController::class, 'reset']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/detail-room/{id}', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::middleware('role:Super Admin|Laboratory Team|Leader')->group(function () {
        // Dosen
        Route::resource('dosen', LecturerController::class);
        // Data Master
        Route::resource('ruangan', RoomController::class);
        Route::resource('jenis-keperluan', TypeOfRoomController::class);
        Route::resource('prodi', StudyProgramController::class);
        Route::resource('matakuliah', CourseController::class);
        Route::resource('inventaris', InventoryController::class);
        // Mahasiswa
        Route::resource('mahasiswa', StudentController::class);
        // Pengaduan
        Route::get('/laporan/pengaduan', [ComplaintController::class, 'report'])->name('laporan-pengaduan.report');
        Route::get('/laporan/pengaduan/export', [ComplaintController::class, 'export'])->name('laporan-pengaduan.export');
        Route::resource('pengaduan', ComplaintController::class);
        Route::post('/pengaduan/done', [ComplaintController::class, 'done']);
        Route::post('/pengaduan/{id}/follow-up', [ComplaintController::class, 'followUp']);
        //Pengajuan Ruangan
        Route::get('/laporan/pengajuan-ruangan', [RoomApplicationController::class, 'report'])->name('laporan-pengajuan.report');
        Route::get('/laporan/pengajuan-ruangan/export', [RoomApplicationController::class, 'export'])->name('laporan-pengajuan.export');
        Route::get('pengajuan-ruangan/jadwal', [RoomApplicationController::class, 'schedule']);
        Route::resource('pengajuan-ruangan', RoomApplicationController::class);
        Route::post('/pengajuan-ruangan/reject', [RoomApplicationController::class, 'reject']);
        Route::post('/pengajuan-ruangan/{id}/approve', [RoomApplicationController::class, 'approve']);
        // Profil
        Route::get('dosen/{id}/profil', [ControllersProfileController::class, 'index'])->name('dosen.profil.index');
        Route::get('dosen/{id}/profil/edit', [ControllersProfileController::class, 'edit'])->name('dosen.profil.edit');
        Route::post('dosen/profil', [ControllersProfileController::class, 'store'])->name('dosen.profil.store');
        Route::post('dosen/profil/change-password', [ControllersProfileController::class, 'changePassword'])->name('dosen.profil.change-password');
    });
    Route::middleware('role:Lecturer|Student')->group(function () {
        Route::get('jenis-keperluan-user/{id}', [TypeOfRoomController::class, 'getData']);
        Route::get('/home', [HomeController::class, 'index'])->name('home.index');
        Route::get('pengaduan-user/getInventory', [ComplaintUserController::class, 'getInventory'])->name('pengaduan-user.getInventory');
        Route::resource('pengaduan-user', ComplaintUserController::class);
        Route::get('pengajuan-user/getCourse', [RoomApplicationUserController::class, 'getCourse'])->name('pengajuan-user.getCourse');
        Route::resource('pengajuan-user', RoomApplicationUserController::class);
        Route::get('profil/{userID}', [ProfileController::class, 'index'])->name('profil.index');
        Route::get('profil/{userID}/edit', [ProfileController::class, 'edit'])->name('profil.edit');
        Route::get('profil/dosen/{userID}/edit', [ProfileController::class, 'editLecturer'])->name('profil.edit-lecturer');
        Route::post('profil', [ProfileController::class, 'store'])->name('profil.store');
        Route::post('profil/dosen', [ProfileController::class, 'storeLecturer'])->name('profil.store-lecturer');
        Route::post('profil/change-password', [ProfileController::class, 'changePassword'])->name('profil.change-password');
        Route::get('data-inventaris', [UserInventoryController::class, 'index'])->name('data-inventaris.index');
    });
});
