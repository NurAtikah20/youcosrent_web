<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\detail_barang;
use App\Models\detail_foto;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $title=' Data Barang';
        $keyword = $request->search;
        $jenis_barang = JenisBarang::all();
        $limit = $request->limit ?? 30;
        $data = Barang::with('jenisbarang')
            ->where(function ($query) use ($keyword) {
                $query->where('nama_barang', 'like', '%' . $keyword . '%')
                    ->orWhere('id_jenis', 'like', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('jenisbarang', function ($query) use ($keyword) {
                $query->where('jenisbarang', 'like', '%' . $keyword . '%'); // assuming 'nama_jenis' is the column in 'jenisbarang' table
            })
            ->paginate($limit);

        $offset = ($data->currentPage() - 1) * $data->perPage();
        // return view('Kategoribarang.index', compact('data', 'offset'));
        return view('barang.index', compact('data', 'offset', 'jenis_barang','title'));
    }


    public function edit_detailbarang(Request $request) {
        $validator = Validator::make($request->all(), [
           
            'ukuran' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|min:0',
          
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $harga = str_replace('.', '', $request->harga);

        $detailBarang = detail_barang::find($request->id);
        $detailBarang->ukuran = $request->ukuran;
        $detailBarang->warna = $request->warna;
        $detailBarang->stok = $request->stok;
        $detailBarang->harga = $harga;
        $detailBarang->save();
        Alert::success('Success', 'Berhasil Edit Data');
        return back();

        
    }


    public function tambah_detailbarang(Request $request) {
        $validator = Validator::make($request->all(), [
           
            'ukuran' => 'required|string|max:255',
            'warna' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|min:0',
          
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $harga = str_replace('.', '', $request->harga);
        $detailBarang = new detail_barang();
        $detailBarang->id_barang = $request->id_barang;
        $detailBarang->ukuran = $request->ukuran;
        $detailBarang->warna = $request->warna;
        $detailBarang->stok = $request->stok;
        $detailBarang->harga = $harga;
        $detailBarang->save();
        Alert::success('Success', 'Berhasil Tambah Data');
        return back();
        
    }
    public function Hapus_($id)
    {
        // dd($id);
        $detailFoto = detail_foto::where('id_barang', $id)->get();
        foreach ($detailFoto as $detail) {
            $path = public_path('produk/' . $detail->foto);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $detailBarang = detail_barang::where('id_barang', $id)->get();
        foreach ($detailBarang as $detail) {
            $detail->delete();
        }
        $detailBarang = detail_barang::where('id_barang', $id)->get();
        foreach ($detailBarang as $detail) {
            $detail->delete();
        }
        $Barang = Barang::find($id);
        $Barang->delete();
        Alert::success('Success', 'Berhasil Hapus Data');
        return back();
    }
    public function detail_barang($id)
    {
        $title='Detail Barang';
        $detailBarang = detail_barang::where('id_barang', $id)->get();
        $barang = Barang::where('id', $id)->first();
        return view('barang.detail_barang', compact('detailBarang', 'barang','title'));
    }
    public function tambah_barang()
    {
        $title='Tambah Barang';
        $jenis_barang = JenisBarang::all();
        return view('barang.tambah_barang', compact('jenis_barang','title'));
    }

    public function edit_barang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required'

        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        // Proses penyimpanan data jika validasi berhasil
        $Barang = Barang::find($request->id);
        $Barang->nama_barang = $request->nama_barang;
        $Barang->deskripsi = $request->deskripsi;
        $Barang->id_jenis = $request->id_jenis;
        $Barang->save();
        Alert::success('Success', 'Berhasil Edit Data');
        return redirect()->route('Barang');
    }

    public function detail_foto($id)
    {
        $title='Detail Foto';
        $barang = Barang::where('id', $id)->first();
        $detal_foto = detail_foto::where('id_barang', $id)->get();
        return view('barang.detail_foto', compact('detal_foto', 'barang','title'));
    }
    public function store_barang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required',
            'ukuran.*' => 'required|string|max:255',
            'warna.*' => 'required|string|max:255',
            'stok.*' => 'required|integer|min:0',
            'harga.*' => 'required|numeric|min:0',
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keterangan.*' => 'required|string|max:255',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            $messages = $validator->errors()->all();

            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }

        // Proses penyimpanan data jika validasi berhasil
        // Simpan data barang ke tabel 'barang'
        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->deskripsi = $request->deskripsi;
        $barang->id_jenis = $request->id_jenis;
        $barang->save();

        // Simpan data detail barang ke tabel 'detail_barang'
        foreach ($request->ukuran as $index => $ukuran) {
            $detailBarang = new detail_barang();
            $detailBarang->id_barang = $barang->id; // Ambil ID barang yang baru saja disimpan
            $detailBarang->ukuran = $ukuran;
            $detailBarang->warna = $request->warna[$index];
            $detailBarang->stok = $request->stok[$index];
            $harga = str_replace('.', '', $request->harga[$index]);
            $detailBarang->harga = $harga;
            $detailBarang->save();
        }

        // Simpan data detail foto ke tabel 'detail_foto'
        foreach ($request->file('gambar') as $index => $gambar) {
            $imageName = time() . '_' . $index . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('produk'), $imageName);

            $detailFoto = new detail_foto();
            $detailFoto->id_barang = $barang->id; // Ambil ID barang yang baru saja disimpan
            $detailFoto->foto = $imageName;
            $detailFoto->keterangan = $request->keterangan[$index];
            $detailFoto->save();
        }

        Alert::success('Success', 'Berhasil Tambah Data');
        return redirect()->route('Barang');
    }


    public function hapus_detailbarang($id)
    {
        $detail_barang = detail_barang::find($id);
        $detail_barang->delete();
        Alert::success('Success', 'Berhasil Hapus Data');
        return back();
    }

    public function edit_detail_foto($id){
        $title='Edit Detail Foto';
        $detail_foto = detail_foto::find($id);
        return view('barang.edit_detailfoto', compact('detail_foto','title'));
    }
    public function update_detail_foto(Request $request,$id) {
        if ($request->gambar) {
            // dd("ffdfd");
            $validator = Validator::make($request->all(), [
                'keterangan' => 'required|string|max:255',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($validator->fails()) {
                $messages = $validator->errors()->all();
                Alert::error($messages)->flash();
                return back()->withErrors($validator)->withInput();
            }
            $detail_foto=detail_foto::find($id);
          
            $detail_foto->keterangan=$request->keterangan;
            if ($detail_foto->foto) {
                $file=(public_path('produk/'.$detail_foto->foto));
                @unlink($file);
            }
            $fileNamee = time().'.'.$request->file('gambar')->getClientOriginalExtension();

            $request->file('gambar')->move(public_path('produk'), $fileNamee);

            $detail_foto->foto=$fileNamee;
            $detail_foto->save();
            Alert::success('Success', 'Berhasil Edit Data');
            return redirect()->route('detail_foto', ['id' => $detail_foto->id_barang]);

        

        }else{
            // dd("dsds");
            $detail_foto=detail_foto::find($id);
      
            $detail_foto->keterangan=$request->keterangan;
            $detail_foto->save();
            Alert::success('Success', 'Berhasil Edit Data');
            return redirect()->route('detail_foto', ['id' => $detail_foto->id_barang]);

        }
        
    }
    public function hapus_detail_foto($id){
        // dd($id);
        $detail_foto = detail_foto::find($id);
        $path = public_path('produk/'.$detail_foto->foto);
        if (file_exists($path)) {
            unlink($path);
        }
        $detail_foto->delete();
        Alert::success('Success', 'Berhasil Hapus Data');
        return back();
    }
    public function tambah_detail_foto(Request $request){

        $validator = Validator::make($request->all(), [
            'keterangan' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $fileName = time().'.'.$request->file('gambar')->getClientOriginalExtension();
        $request->file('gambar')->move(public_path('produk'), $fileName);
        $detail_foto = new detail_foto();
        $detail_foto->id_barang = $request->id_barang;
        $detail_foto->keterangan = $request->keterangan;
        $detail_foto->foto = $fileName;
        $detail_foto->save();
        Alert::success('Success', 'Berhasil Tambah Data');
        return redirect()->route('detail_foto', ['id' => $detail_foto->id_barang]);
    }
}
