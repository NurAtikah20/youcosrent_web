<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisBarang;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\PembukuanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LandingPageController;
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




Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/single-product', function () {
    return view('single-product');
})->name('single-product');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::get('/', [LandingPageController::class, 'show']);
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('/lupapassword', [AuthController::class, 'lupapassword'])->name('lupapassword')->middleware('guest');
Route::post('/actlupapassword', [AuthController::class, 'actlupapassword'])->name('actlupapassword')->middleware('guest');
Route::get('/validasi-lupapassword/{token}', [AuthController::class, 'validasilupapassword'])->name('validasi-lupapassword')->middleware('guest');
Route::get('/validasi-lupapassword/{token}', [AuthController::class, 'validasilupapassword'])->name('validasi-lupapassword')->middleware('guest');
Route::post('/actvalidasi-lupapassword', [AuthController::class, 'actvalidasi-lupapassword'])->name('actvalidasi-lupapassword')->middleware('guest');
Route::post('/resetpassword', [AuthController::class, 'resetpassword'])->name('resetpassword')->middleware('guest');
Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');



// Middleware to protect routes for authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jenisbarang', [JenisBarangController::class, 'index'])->name('JenisBarang');
    Route::post('/tambah_jenis', [JenisBarangController::class, 'tambahjenis'])->name('tambah_jenis');
    Route::post('/edit_jenis', [JenisBarangController::class, 'edit_jenis'])->name('edit_jenis');
    Route::get('/hapus_jenisbarang/{id}', [JenisBarangController::class, 'Hapus_jenis'])->name('JenisBarangHapus');

    Route::get('/barang', [BarangController::class, 'index'])->name('Barang');
    Route::get('/hapus_barang/{id}', [BarangController::class, 'Hapus_'])->name('hapus_barang');
    Route::get('/tambah_barang', [BarangController::class, 'tambah_barang'])->name('tambahBarang');
    Route::post('/store_barang', [BarangController::class, 'store_barang'])->name('tambahBarangsimpan');
    Route::post('/edit_barang', [BarangController::class, 'edit_barang'])->name('edit_barang');
    Route::post('/edit_detailbarang', [BarangController::class, 'edit_detailbarang'])->name('edit_detailbarang');
    Route::post('/tambah_detailbarang', [BarangController::class, 'tambah_detailbarang'])->name('tambah_detailbarang');
    Route::post('/tambah_detail_foto', [BarangController::class, 'tambah_detail_foto'])->name('tambah_detail_foto');
    Route::get('/detail_foto/{id}', [BarangController::class, 'detail_foto'])->name('detail_foto');
    Route::get('/edit_detail_foto/{id}', [BarangController::class, 'edit_detail_foto'])->name('edit_detail_foto');
    Route::get('/hapus_detail_foto/{id}', [BarangController::class, 'hapus_detail_foto'])->name('hapus_detail_foto');
    Route::put('/update_detail_foto/{id}', [BarangController::class, 'update_detail_foto'])->name('update_detail_foto');
    Route::get('/detail_barang/{id}', [BarangController::class, 'detail_barang'])->name('detail_barang');
    Route::get('hapus_detailbrg/{id}', [BarangController::class, 'hapus_detailbarang'])->name('hapus_detailbarang');
    // Route::post('/edit_', [BarangController::class, 'edit_'])->name('edit_');
    Route::get('/hapus_barang/{id}', [BarangController::class, 'Hapus_'])->name('BarangHapus');

    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
    Route::get('/hapus_pengeluaran/{id}', [PengeluaranController::class, 'hapus_pengeluaran'])->name('hapus_pengeluaran');
    Route::post('/tambah_pengeluaran', [PengeluaranController::class, 'tambah_data'])->name('pengeluaran.store');
    Route::post('/update_data_pengeluaran', [PengeluaranController::class, 'update_data'])->name('pengeluaran.update_data');
    Route::get('/transaksi_belumterkonfirmasi', [TransaksiController::class, 'konfirmasi_pesanan'])->name('transaksi_belumterkonfirmasi');
    Route::get('/transaksi_pembayaran', [TransaksiController::class, 'pembayaran_pesanan'])->name('transaksi_pembayaran');
    Route::get('/detail_transaksi_konfirmasi/{id}', [TransaksiController::class, 'detail_konfirmasi_pesanan'])->name('detail_transaksi_belumterkonfirmasi');
    Route::get('/detail_transaksi_barang/{id}', [TransaksiController::class, 'detail_konfirmasi_barang'])->name('detail_konfirmasi_barang');
    Route::post('/konfirmasi_pesanan', [TransaksiController::class, 'update_konfirmasi'])->name('konfirmasi_pesanan');
    Route::post('/pengembalian_dan_bayar', [TransaksiController::class, 'pengembalian_dan_bayar'])->name('pengembalian_dan_bayar');
    Route::get('/data_transaksi_sudahdikembalikan', [TransaksiController::class, 'data_sudahdikembalikan'])->name('data_transaksi_sudahdikembalikan');
    Route::get('/barang_dikembalikan/{id}', [TransaksiController::class, 'barang_dikembalikan'])->name('barang_dikembalika');
    Route::get('/pembukuan', [PembukuanController::class, 'index'])->name('pembukuan');
    Route::get('/pembukuan/{tanggal_awal}/{tanggal_akhir}', [PembukuanController::class, 'cekpembukuan'])->name('cekpembukuan');
    
    

});

// Define the login routes outside of the middleware to allow unauthenticated users to access them
