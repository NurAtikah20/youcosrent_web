<?php

namespace App\Http\Controllers;

use App\Models\pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $title = "Pengeluaran";
        $data = pengeluaran::where('nominal', 'like', '%' . $request->search . '%')->where('tanggal', 'like', '%' . $request->search . '%')->where('keterangan', 'like', '%' . $request->search . '%')->paginate(10);
        $offset = ($data->currentPage() - 1) * $data->perPage();
        return view('pengeluaran.index', compact('data', 'offset', 'title'));
    }
    public function tambah_data(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominal' => 'required|min:0',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $pengeluaran = new pengeluaran();
        $nominal = str_replace('.', '', $request->nominal);
        $pengeluaran->nominal = $nominal;
        $pengeluaran->keterangan = $request->keterangan;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
        $pengeluaran->tanggal = $tanggal;
        $pengeluaran->save();
        Alert::success('Data Berhasil ditambah')->flash();
        return back();
    }
    public function hapus_pengeluaran($id)
    {
        $pengeluaran = pengeluaran::find($id);
        $pengeluaran->delete();
        Alert::success('Data Berhasil dihapus')->flash();
        return back();
    }
    public function update_data(Request $request) {
        $validator = Validator::make($request->all(), [
            'nominal' => 'required|min:0',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
           $nominal = str_replace('.', '', $request->nominal);
        $pengeluaran=pengeluaran::find($request->id);
        $pengeluaran->nominal=$nominal;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
        $pengeluaran->tanggal=$tanggal;
        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->save();
        Alert::success('Data Berhasil diubah')->flash();
        return back();
        
    }
}
