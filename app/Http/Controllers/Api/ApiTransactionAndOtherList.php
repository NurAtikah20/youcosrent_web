<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\detail_barang;
use App\Models\detail_transaksi;
use Illuminate\Support\Facades\Validator;
use App\Models\pelanggan;
use App\Models\transaksi;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ApiTransactionAndOtherList extends Controller
{
    public function Transaction(Request $request)
    {
        $data = json_decode($request->input('data'), true);

        // Ensure $data is an array
        if (!is_array($data)) {
            return $this->sendMassage('Invalid data', 400, false);
        }

        // Ensure the detail_transaksi data is an array
        if (!is_array($data['detail_transaksi'])) {
            return $this->sendMassage('Invalid detail_transaksi data', 400, false);
        }

        $now = Carbon::now();

        // Handle image upload if present
        $buktiBayarPath = null;
        if ($request->hasFile('transaksi.bukti_bayar')) {
            $image = $request->file('transaksi.bukti_bayar');
            $buktiBayarPath = 'produk/' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('produk'), $buktiBayarPath);
        }

        // Check stock availability
        foreach ($data['detail_transaksi'] as $detail) {
            $detailBarang = detail_barang::find($detail['id_detailbarang']);
            if (!$detailBarang || $detail['qty'] > $detailBarang->stok) {
                return $this->sendMassage('Pesanan anda melebihi batas stok', 400, false);
            }
        }

        // Create the Transaksi
        $transaksi = Transaksi::create([
            'id_user' => $data['transaksi']['id_user'],
            'id_pelanggan' => $data['transaksi']['id_pelanggan'],
            'tanggal_sewa' => $data['transaksi']['tanggal_sewa'],
            'tanggal_akhir' => $data['transaksi']['tanggal_akhir'],
            'tanggal_kembali' => $data['transaksi']['tanggal_kembali'],
            'durasi' => $data['transaksi']['durasi'],
            'bayar' => $data['transaksi']['bayar'],
            'kurang_bayar' => $data['transaksi']['kurang_bayar'],
            'total_harga' => $data['transaksi']['total_harga'],
            'total_denda' => $data['transaksi']['total_denda'],
            'status_pengembalian' => $data['transaksi']['status_pengembalian'],
            'status_konfirmasi' => $data['transaksi']['status_konfirmasi'],
            'model_bayar' => $data['transaksi']['model_bayar'],
            'bukti_bayar' => $buktiBayarPath,
            'total_ongkir' => $data['transaksi']['total_ongkir'],
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Create DetailTransaksi
        foreach ($data['detail_transaksi'] as $detail) {
            detail_transaksi::create([
                'id_transkasi' => $transaksi->id,
                'id_detailbarang' => $detail['id_detailbarang'],
                'qty' => $detail['qty'],
                'subtotal_harga' => $detail['subtotal_harga'],
                'created_at' => $now,
                'updated_at' => $now
            ]);

            $detailBarang = detail_barang::find($detail['id_detailbarang']);
            $detailBarang->stok -= $detail['qty'];
            $detailBarang->save();
        }

        return $this->sendMassage('Pesanan anda berhasil', 200, true);
    }





    public function barang(Request $request)
    {
        try {

            $barangs = Barang::with(['detailBarang', 'jenisbarang', 'detailfoto'])->get();

            $result = $barangs->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'deskripsi' => $barang->deskripsi,
                    'id_jenis' => $barang->id_jenis,
                    'jenisbarang' => $barang->jenisBarang->jenisbarang,
                    'created_at' => $barang->created_at,
                    'updated_at' => $barang->updated_at,
                    'detailbarang' => $barang->detailBarang,
                    'detailfoto' => $barang->detailfoto
                ];
            });

            return $this->sendMassage($result, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function barangBaru(Request $request)
    {
        try {

            $barangs = Barang::with(['detailBarang', 'jenisbarang', 'detailfoto'])
                ->orderBy('created_at', 'desc')->get();

            $result = $barangs->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'deskripsi' => $barang->deskripsi,
                    'id_jenis' => $barang->id_jenis,
                    'jenisbarang' => $barang->jenisBarang->jenisbarang,
                    'created_at' => $barang->created_at,
                    'updated_at' => $barang->updated_at,
                    'detailbarang' => $barang->detailBarang,
                    'detailfoto' => $barang->detailfoto
                ];
            });

            return $this->sendMassage($result, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function barangKategoriA(Request $request)
    {
        try {
            $barangs = Barang::with(['detailBarang', 'jenisbarang', 'detailfoto'])
                ->whereHas('jenisbarang', function ($query) {
                    $query->where('jenisbarang', 'Kostum');
                })
                ->get();

            $result = $barangs->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'deskripsi' => $barang->deskripsi,
                    'id_jenis' => $barang->id_jenis,
                    'jenisbarang' => $barang->jenisBarang->jenisbarang,
                    'created_at' => $barang->created_at,
                    'updated_at' => $barang->updated_at,
                    'detailbarang' => $barang->detailBarang,
                    'detailfoto' => $barang->detailfoto
                ];
            });

            return $this->sendMassage($result, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function barangKategoriB(Request $request)
    {
        try {
            $barangs = Barang::with(['detailBarang', 'jenisbarang', 'detailfoto'])
                ->whereHas('jenisbarang', function ($query) {
                    $query->where('jenisbarang', 'Aksesoris');
                })
                ->get();

            $result = $barangs->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'deskripsi' => $barang->deskripsi,
                    'id_jenis' => $barang->id_jenis,
                    'jenisbarang' => $barang->jenisBarang->jenisbarang,
                    'created_at' => $barang->created_at,
                    'updated_at' => $barang->updated_at,
                    'detailbarang' => $barang->detailBarang,
                    'detailfoto' => $barang->detailFoto
                ];
            });

            return $this->sendMassage($result, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function barangKategoriC(Request $request)
    {
        try {
            $barangs = Barang::with(['detailBarang', 'jenisbarang', 'detailFoto'])
                ->whereHas('jenisbarang', function ($query) {
                    $query->where('jenisbarang', 'Properti');
                })
                ->get();

            $result = $barangs->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'deskripsi' => $barang->deskripsi,
                    'id_jenis' => $barang->id_jenis,
                    'jenisbarang' => $barang->jenisBarang->jenisbarang,
                    'created_at' => $barang->created_at,
                    'updated_at' => $barang->updated_at,
                    'detailbarang' => $barang->detailBarang,
                    'detailfoto' => $barang->detailFoto
                ];
            });

            return $this->sendMassage($result, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function barangKategoriD(Request $request)
    {
        try {
            $barangs = Barang::with(['detailBarang', 'jenisbarang', 'detailFoto'])
                ->whereHas('jenisbarang', function ($query) {
                    $query->where('jenisbarang', 'Sepatu');
                })
                ->get();

            $result = $barangs->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'deskripsi' => $barang->deskripsi,
                    'id_jenis' => $barang->id_jenis,
                    'jenisbarang' => $barang->jenisBarang->jenisbarang,
                    'created_at' => $barang->created_at,
                    'updated_at' => $barang->updated_at,
                    'detailbarang' => $barang->detailBarang,
                    'detailfoto' => $barang->detailFoto
                ];
            });

            return $this->sendMassage($result, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function barangKategoriE(Request $request)
    {
        try {
            $barangs = Barang::with(['detailBarang', 'jenisbarang', 'detailFoto'])
                ->whereHas('jenisbarang', function ($query) {
                    $query->where('jenisbarang', 'OneTime');
                })
                ->get();

            $result = $barangs->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'deskripsi' => $barang->deskripsi,
                    'id_jenis' => $barang->id_jenis,
                    'jenisbarang' => $barang->jenisBarang->jenisbarang,
                    'created_at' => $barang->created_at,
                    'updated_at' => $barang->updated_at,
                    'detailbarang' => $barang->detailBarang,
                    'detailfoto' => $barang->detailFoto
                ];
            });

            return $this->sendMassage($result, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function barangKategoriF(Request $request)
    {
        try {
            $barangs = Barang::with(['detailBarang', 'jenisbarang', 'detailFoto'])
                ->whereHas('jenisbarang', function ($query) {
                    $query->where('jenisbarang', 'DreamCloset');
                })
                ->get();

            $result = $barangs->map(function ($barang) {
                return [
                    'id' => $barang->id,
                    'nama_barang' => $barang->nama_barang,
                    'deskripsi' => $barang->deskripsi,
                    'id_jenis' => $barang->id_jenis,
                    'jenisbarang' => $barang->jenisBarang->jenisbarang,
                    'created_at' => $barang->created_at,
                    'updated_at' => $barang->updated_at,
                    'detailbarang' => $barang->detailBarang,
                    'detailfoto' => $barang->detailFoto
                ];
            });

            return $this->sendMassage($result, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function dataPesanan(Request $request)
    {

        try {

            $token = $request->bearerToken();
            $user = pelanggan::where('token', $token)->first();

            if (!$user) {
                return $this->sendMassage('User not found', 404, false);
            }

            $transaksis = Transaksi::with(['detailTransaksi.barang.detailbarang', 'detailTransaksi.barang.jenisbarang', 'detailTransaksi.barang.detailfoto'])
                ->where('id_pelanggan', $user->id)
                ->where(function ($query) {
                    $query->where('status_pengembalian', '!=', 'sudah')
                        ->orWhere('status_konfirmasi', '!=', 'sudah_terkonfirmasi');
                })
                ->get();


            return $this->sendMassage($transaksis, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function dataHistory(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $user = pelanggan::where('token', $token)->first();

            if (!$user) {
                return $this->sendMassage('User not found', 404, false);
            }

            $transaksis = Transaksi::with(['detailTransaksi.barang.detailbarang', 'detailTransaksi.barang.jenisbarang', 'detailTransaksi.barang.detailfoto'])
                ->where('id_pelanggan', $user->id)
                ->where(function ($query) {
                    $query->where('status_pengembalian', '=', 'sudah')
                        ->orWhere('status_konfirmasi', '=', 'sudah_terkonfirmasi');
                })
                ->get();

            return $this->sendMassage($transaksis, 200, true);
        } catch (\Exception $e) {
            return $this->sendMassage($e->getMessage(), 400, false);
        }
    }

    public function sendMassage($text, $kode, $status)
    {
        return response()->json([
            'data' => $text,
            'code' => $kode,
            'status' => $status
        ], $kode);
    }
}
