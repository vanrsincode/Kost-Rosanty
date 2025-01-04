<?php
use App\Http\Controllers\AksesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SelectController;
use App\Http\Controllers\SewaKamarController;
use App\Http\Controllers\TagihanController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login/proses', 'proses')->name('proses.login');
    Route::get('logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Profile
    Route::get('profile', [ProfileController::class, 'indexProfile']);
    Route::get('dataProfile', [ProfileController::class, 'getDataProfile']);
    Route::post('profile/{profile}', [ProfileController::class, 'updateProfile']);

    Route::group(['middleware' => ['checkRole:1,3']], function () {
        // Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/filter', [LaporanController::class, 'filter'])->name('laporan.filter');
        Route::get('laporan/cetak', [LaporanController::class, 'cetakPDF'])->name('laporan.cetak');
        // Penghuni
        Route::get('dataPenghuni', [PenghuniController::class, 'dataTablePenghuni']);
        Route::post('reset-penghuni/{id}', [PenghuniController::class, 'resetAkun']);
        Route::resource('penghuni', PenghuniController::class)->except('create','store','edit','show','update');
        Route::post('penghuni/del/{id}', [PenghuniController::class, 'destroy'])->name('penghuni.destroy');
    });

    // Role 1 Admin
    Route::group(['middleware' => ['checkRole:1']], function () {
        // Fasilitas
        Route::get('dataFasilitas', [FasilitasController::class, 'dataTableFasilitas'])->name('dataFasilitas');
        Route::resource('fasilitas', FasilitasController::class)->except('create', 'edit');
        Route::post('fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
        Route::post('fasilitas/del/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');
        // Kamar
        Route::get('dataKamar', [KamarController::class, 'dataTableKamar']);
        Route::resource('kamar', KamarController::class)->except('create', 'edit');
        Route::post('kamar/{id}', [KamarController::class, 'update'])->name('kamar.update');
        Route::post('kamar/del/{id}', [KamarController::class, 'destroy'])->name('kamar.destroy');
        // Penyewa Kamar
        Route::get('dataSewaKamar', [SewaKamarController::class, 'dataTableSewaKamar']);
        Route::resource('penyewa-kamar', SewaKamarController::class)->except('create', 'edit');
        Route::post('penyewa-kamar/{id}', [SewaKamarController::class, 'update'])->name('penyewa-kamar.update');
        Route::post('penyewa-kamar/del/{id}', [SewaKamarController::class, 'destroy'])->name('penyewa-kamar.destroy');
        // Transaksi Tagihan
        Route::get('dataTagihan', [TagihanController::class, 'dataTableTagihan']);
        Route::get('/tagihan/penghuni-belum-ada', [TagihanController::class, 'getPenghuniBelumAda']);
        Route::post('cash-tagihan/{id}', [TagihanController::class, 'bayarTunai']);
        Route::resource('tagihan', TagihanController::class)->except('create', 'edit', 'show', 'update');
        Route::post('tagihan/del/{id}', [TagihanController::class, 'destroy'])->name('tagihan.destroy');
        // Transaksi Pembayaran
        Route::get('dataPembayaran', [PembayaranController::class, 'dataTablePembayaran']);
        Route::resource('pembayaran', PembayaranController::class)->except('create','store','show','edit','update','destroy');
        // Penglola Hak Akses
        Route::get('dataPengelola', [AksesController::class, 'dataTablePengelola']);
        Route::post('reset-pengelola/{id}', [AksesController::class, 'resetAkun']);
        Route::resource('hak-akses', AksesController::class)->except('create', 'edit');
        Route::post('hak-akses/{id}', [AksesController::class, 'update'])->name('hak-akses.update');
        Route::post('hak-akses/del/{id}', [AksesController::class, 'destroy'])->name('hak-akses.destroy');
        // Select All
        Route::controller(SelectController::class)->group(function () {
            Route::get('selectFasilitas', 'dataSelectFasilitas');
            Route::get('selectKamar', 'dataSelectKamar');
        });
    });

    // Role 2 Penghuni
    Route::group(['middleware' => ['checkRole:2']], function () {
        // Profile
        Route::get('user/profile', [ProfileController::class, 'indexProfilePenghuni']);
        Route::get('dataProfilePenghuni', [ProfileController::class, 'getDataProfilePenghuni']);
        Route::post('user/profile/{id}', [ProfileController::class, 'updateProfilePenghuni']);
        // Riwayat
        Route::resource('user/riwayat', RiwayatController::class)->except('create','store','edit','show','update','destroy');
    });
});

Route::get('/run-clear', function () {
    $output = [];
    Artisan::call('config:clear');
    $output[] = Artisan::output();
    Artisan::call('route:clear');
    $output[] = Artisan::output();
    Artisan::call('view:clear');
    $output[] = Artisan::output();
    Artisan::call('optimize:clear');
    $output[] = Artisan::output();
    return response()->json(['output' => $output]);
});