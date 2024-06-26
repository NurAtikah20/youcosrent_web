<?php

namespace App\Http\Controllers;

use App\Models\pengeluaran;
use App\Models\transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PembukuanController extends Controller
{
    public function index()
    {
        $title = "pembukuan";

        $pendapatan_hariini = transaksi::whereDate('tanggal_kembali', now()->toDateString())
            ->where('status_pengembalian', 'sudah')
            ->where('status_konfirmasi', 'sudah_terkonfirmasi')
            ->sum('total_harga');
        $pengeluaran = pengeluaran::whereDate('tanggal', now()->toDateString())

            ->sum('nominal');
        if (($pendapatan_hariini >= $pengeluaran)) {
            $laba = $pendapatan_hariini - $pengeluaran;
            $kerugian = 0;
            # code...
        } else {
            # code...
            $laba = 0;
            $kerugian = $pengeluaran - $pendapatan_hariini;
        }

        return view('pembukuan.index', compact('title', 'pendapatan_hariini', 'pengeluaran', 'laba', 'kerugian'));
    }
    public function cekpembukuan($tanggalawal, $tanggalakhir)
    {
        $title = "pembukuan";
        $tanggalawal = Carbon::parse($tanggalawal)->format('Y-m-d');
        $tanggalakhir = Carbon::parse($tanggalakhir)->format('Y-m-d');
        $pendapatan = transaksi::whereBetween('tanggal_kembali', [$tanggalawal, $tanggalakhir])
            ->where('status_pengembalian', 'sudah')
            ->where('status_konfirmasi', 'sudah_terkonfirmasi')
            ->sum('total_harga');
        $pengeluaran = pengeluaran::whereBetween('tanggal', [$tanggalawal, $tanggalakhir])

            ->sum('nominal');
        if (($pendapatan >= $pengeluaran)) {
            $laba = $pendapatan - $pengeluaran;
            $kerugian = 0;
            # code...
        } else {
            # code...
            $laba = 0;
            $kerugian = $pengeluaran - $pendapatan;
        }
        $cek="2024-12-12";

        return view('pembukuan.cekpembukuan', compact('title', 'pendapatan', 'pengeluaran', 'laba', 'kerugian','cek', 'tanggalawal', 'tanggalakhir'));
    }
}
