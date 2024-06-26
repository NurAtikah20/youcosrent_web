<?php

namespace App\Http\Controllers;

use App\Models\pelanggan;
use App\Models\pengeluaran;
use App\Models\transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $title="Halaman Dashboard";


        $melebihi_waktu=transaksi::where('tanggal_akhir','<',now()->toDateString())->where('status_konfirmasi','sudah_terkonfirmasi')->where('status_pengembalian','belum')->count();
        $pelanggan=pelanggan::count();
        $pendapatan_hariini=transaksi::whereDate('tanggal_kembali', now()->toDateString())
        ->where('status_pengembalian', 'sudah')
        ->where('status_konfirmasi', 'sudah_terkonfirmasi')
        ->sum('total_harga');
        $pengeluaran=pengeluaran::whereDate('tanggal', now()->toDateString())
        
        ->sum('nominal');

        $tahunIni = Carbon::now()->year;

        // Query untuk menghitung total_harga per bulan pada tahun ini
        $tahunIni = Carbon::now()->year;

        // Query untuk menghitung total_harga per bulan pada tahun ini
        $totalHargaBulanan = transaksi::select(
                DB::raw('MONTH(tanggal_kembali) as bulan'),
                DB::raw('SUM(total_harga) as total_harga')
            )
            ->whereYear('tanggal_kembali', $tahunIni)
            ->where('status_konfirmasi', 'sudah_terkonfirmasi')
            ->where('status_pengembalian', 'sudah')
            ->groupBy(DB::raw('MONTH(tanggal_kembali)'))
            ->get();

        $totalHargaBulanan = $totalHargaBulanan->map(function ($item) {
            $item->bulan = Carbon::create()->month($item->bulan)->locale('id')->isoFormat('MMMM');
            return $item;
        });

        // Query untuk menghitung total_nominal per bulan pada tahun ini
        $totalPengeluaranBulanan = pengeluaran::select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('SUM(nominal) as total_nominal')
            )
            ->whereYear('tanggal', $tahunIni)
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->get();

        $totalPengeluaranBulanan = $totalPengeluaranBulanan->map(function ($item) {
            $item->bulan = Carbon::create()->month($item->bulan)->locale('id')->isoFormat('MMMM');
            return $item;
        });
        // dd($totalHargaBulanan);


      
        return view('dashboard', compact('title', 'melebihi_waktu', 'pelanggan', 'pendapatan_hariini', 'pengeluaran', 'totalHargaBulanan', 'totalPengeluaranBulanan'));
    }
}
