<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
// use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JenisBarangController extends Controller
{
    public function index(Request $request)
    {
        $title="Jenis Barang";
        $keyword = $request->search;
        $limit = $request->limit ?? 30;
        $data = JenisBarang::paginate($limit);
        $offset = ($data->currentPage() - 1) * $data->perPage();
        return view('Kategoribarang.index', compact('data', 'offset','title'));
    }
    public function tambahjenis(Request $request)
    {
        $data = ["jenisbarang" => $request->jenisbarang];
        JenisBarang::create($data);
        Alert::success('Success', 'Berhasil Tambah Data');
        return back();
    }
    public function Hapus_jenis($id)
    {
        $JenisBarang = JenisBarang::find($id);
        $JenisBarang->delete();
        Alert::success('Success', 'Berhasil Hapus Data');
        return back();
    }
    public function edit_jenis(Request $request)
    {
        $data=["jenisbarang"=>$request->jenisbarang];
        JenisBarang::where('id',$request->id)->update($data);
        Alert::success('Success', 'Berhasil Ubah Data');
        return back();
    }
}
