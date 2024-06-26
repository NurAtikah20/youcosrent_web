<?php

namespace App\Http\Controllers;

use App\Models\detail_barang;
use App\Models\detail_transaksi;
use App\Models\transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function konfirmasi_pesanan(Request $request)
    {
        $title = ' Data Pesanan Belum terkonfirmasi';
        $keyword = $request->search;
        // $jenis_barang = JenisBarang::all();
        $limit = $request->limit ?? 30;
        $data = transaksi::with('pelanggan')
            ->where('status_konfirmasi', 'belum_terkonfirmasi') // atau '0', tergantung nilai yang digunakan di database
            ->where(function ($query) use ($keyword) {
                $query->where('tanggal_sewa', 'like', '%' . $keyword . '%')
                    ->orWhere('tanggal_akhir', 'like', '%' . $keyword . '%')
                    ->orWhere('durasi', 'like', '%' . $keyword . '%')
                    ->orWhere('bayar', 'like', '%' . $keyword . '%')
                    ->orWhere('kurang_bayar', 'like', '%' . $keyword . '%')
                    ->orWhere('total_harga', 'like', '%' . $keyword . '%')
                    ->orWhere('tanggal_kembali', 'like', '%' . $keyword . '%')
                    ->orWhereHas('pelanggan', function ($query) use ($keyword) {
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    });
            })
            ->paginate($limit);



        $offset = ($data->currentPage() - 1) * $data->perPage();
        // dd($data);
        // return view('Kategoribarang.index', compact('data', 'offset'));
        return view('transaksi.konfirmasi_pesanan', compact('data', 'offset', 'title'));
    }


    public function update_konfirmasi(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'status_konfirmasi' => 'required|in:sudah_terkonfirmasi,tidak_terkonfirmasi',
        ], [
            'status_konfirmasi.required' => 'Status konfirmasi wajib diisi.',
            'status_konfirmasi.in' => 'Status konfirmasi tidak valid.',
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $transaksi = transaksi::findOrFail($request->id);
        $detail_transaksi = detail_transaksi::where('id_transkasi', $request->id)->get();
        if ($request->status_konfirmasi == "tidak_terkonfirmasi") {
            foreach ($detail_transaksi as $item) {
                $detail_barang = detail_barang::with('barang')->where('id', $item->id_detailbarang)->first();
                $detail_barangg = detail_barang::find($item->id_detailbarang);
                $stok = $detail_barang->stok;

                // dump($stok);
                $pengurangan = $stok + $item->qty;
                // dump($pengurangan);
                $detail_barangg->stok = $pengurangan;
                $detail_barangg->save();
            }
        }


        $transaksi->status_konfirmasi = $request->status_konfirmasi;
        $transaksi->save();
        Alert::success('Data Berhasil Dikonfirmasi')->flash();
        return back();
    }

    public function detail_konfirmasi_pesanan($id)
    {
        $title = 'Detail Konfirmasi Pesanan';
        $data = detail_transaksi::with('detail_barang')->where('id_transkasi', $id)->get();

        return view('transaksi.detail_konfirmasi_pesanan', compact('data', 'title'));
    }
    public function detail_konfirmasi_barang($id)
    {
        $title = 'Detail Konfirmasi Pesanan';
        $data = detail_transaksi::with('detail_barang')->where('id_transkasi', $id)->get();

        return view('transaksi.detail_konfirmasi_barang', compact('data', 'title'));
    }



    public function pembayaran_pesanan(Request $request)
    {
        $title = ' Data Pesanan Belum terkonfirmasi';
        $keyword = $request->search;
        // $jenis_barang = JenisBarang::all();
        $limit = $request->limit ?? 30;
        $data = transaksi::with('pelanggan')
            ->where('status_konfirmasi', 'sudah_terkonfirmasi') // atau '0', tergantung nilai yang digunakan di database
            ->where('status_pengembalian', 'belum') // atau '0', tergantung nilai yang digunakan di database
            ->where(function ($query) use ($keyword) {
                $query->where('tanggal_sewa', 'like', '%' . $keyword . '%')
                    ->orWhere('tanggal_akhir', 'like', '%' . $keyword . '%')
                    ->orWhere('durasi', 'like', '%' . $keyword . '%')
                    ->orWhere('bayar', 'like', '%' . $keyword . '%')
                    ->orWhere('kurang_bayar', 'like', '%' . $keyword . '%')
                    ->orWhere('total_harga', 'like', '%' . $keyword . '%')
                    ->orWhere('tanggal_kembali', 'like', '%' . $keyword . '%')
                    ->orWhereHas('pelanggan', function ($query) use ($keyword) {
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    });
            })
            ->paginate($limit);



        $offset = ($data->currentPage() - 1) * $data->perPage();
        // dd($data);
        // return view('Kategoribarang.index', compact('data', 'offset'));
        return view('transaksi.pembayaran_pesanan', compact('data', 'offset', 'title'));
    }
    public function pengembalian_dan_bayar(Request $request)
    {
        $request->all();
        $bayar = 0;
        $model_pembayaran=null;
        $transaksi = transaksi::find($request->id);
        if (($request->bayar != null) && ($request->total_denda != null)) {
            $model_pembayaran=$request->model_bayar;
            $bayar = str_replace('.', '', $request->bayar);
            $total_denda = str_replace('.', '', $request->total_denda);
            $kurang_bayar = str_replace('.', '', $request->kurang_bayar);
            if ($request->bukti_bayar != null) {
                // dd("ddsds");
                $validator = Validator::make($request->all(), [
                    // 'bayar' => 'required|min:0',
                    'kurang_bayar' => 'required|min:0',
                    'total_denda' => 'required|min:0',
                    'keterangan_denda' => 'required',
                    'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                    'total_harga' => 'required|min:0',
                    'model_bayar' => 'required',
    
                ], [
                    'bukti_bayar.required' => 'Bukti bayar wajib diisi.',
                ]);
    
                if ($validator->fails()) {
                    $messages = $validator->errors()->all();
                    Alert::error($messages)->flash();
                    return back()->withErrors($validator)->withInput();
                }
                $fileName = time() . '.' . $request->file('bukti_bayar')->getClientOriginalExtension();
                $request->file('bukti_bayar')->move(public_path('bukti_bayarr'), $fileName);
                $transaksi->bukti_bayar2 = $fileName;
                
            } else {
                $validator = Validator::make($request->all(), [
                    'bayar' => 'required|min:0',
                    'kurang_bayar' => 'required|min:0',
                    'model_bayar' => 'required',
                    'total_harga' => 'required|min:0',
    
                ]);
    
                if ($validator->fails()) {
                    $messages = $validator->errors()->all();
                    Alert::error($messages)->flash();
                }
            }
            if ($bayar < $kurang_bayar) {
                Alert::error("Pembayaran Kurang")->flash();
                return back()->withInput();
            }
        }

       
        
        $denda = 0;
        if ($request->total_denda != null) {

            $denda = str_replace('.', '', $request->total_denda);
        }
        $bayar = str_replace('.', '', $request->bayar);

        $total_harga = str_replace('.', '', $request->total_harga);
        // $kembalian = str_replace('.', '', $request->kembalian);

        $transaksi->bayar2 = $bayar;
        // $transaksi->kembalian = $kembalian;
        $transaksi->total_denda = $denda;
        $transaksi->tanggal_kembali = Carbon::now()->format('Y-m-d');

        $transaksi->keterangan_denda = $request->keterangan_denda;
        $transaksi->kurang_bayar = 0;
        $transaksi->total_harga = $total_harga;
        $transaksi->model_bayar2 = $model_pembayaran;
        $transaksi->status_pengembalian = "sudah";
        $transaksi->save();

        $detail_transaksi = detail_transaksi::where('id_transkasi', $request->id)->get();

        foreach ($detail_transaksi as $item) {
            $detail_barang = detail_barang::with('barang')->where('id', $item->id_detailbarang)->first();
            $detail_barangg = detail_barang::find($item->id_detailbarang);
            $stok = $detail_barang->stok;

            // dump($stok);
            $pengurangan = $stok + $item->qty;
            // dump($pengurangan);
            $detail_barangg->stok = $pengurangan;
            $detail_barangg->save();
        }

        Alert::success('Success', 'Pemabayaran berhasil Data');
        return back();
    }

    public function data_sudahdikembalikan(Request $request)
    {

        $title = "Data Transaksi Sudah Dikembalikan";

        $keyword = $request->search;
        // $jenis_barang = JenisBarang::all();
        $limit = $request->limit ?? 30;
        $data = transaksi::with('pelanggan')
            ->where('status_konfirmasi', 'sudah_terkonfirmasi') // atau '0', tergantung nilai yang digunakan di database
            ->where('status_pengembalian', 'sudah') // atau '0', tergantung nilai yang digunakan di database
            ->where(function ($query) use ($keyword) {
                $query->where('tanggal_sewa', 'like', '%' . $keyword . '%')
                    ->orWhere('tanggal_akhir', 'like', '%' . $keyword . '%')
                    ->orWhere('durasi', 'like', '%' . $keyword . '%')
                    ->orWhere('bayar', 'like', '%' . $keyword . '%')
                    ->orWhere('kurang_bayar', 'like', '%' . $keyword . '%')
                    ->orWhere('total_harga', 'like', '%' . $keyword . '%')
                    ->orWhere('tanggal_kembali', 'like', '%' . $keyword . '%')
                    ->orWhereHas('pelanggan', function ($query) use ($keyword) {
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    });
            })
            ->paginate($limit);



        $offset = ($data->currentPage() - 1) * $data->perPage();
        // dd($data);
        // return view('Kategoribarang.index', compact('data', 'offset'));
        return view('transaksi.transaksi_barangdikembalikan', compact('data', 'offset', 'title'));
    }


    public function barang_dikembalikan($id)
    {
        $title = 'Detail  Pesanan Sudah Dikembalikan';
        $data = detail_transaksi::with('detail_barang')->where('id_transkasi', $id)->get();

        return view('transaksi.detail_barang_sudahdikembalikan', compact('data', 'title'));
    }
}
