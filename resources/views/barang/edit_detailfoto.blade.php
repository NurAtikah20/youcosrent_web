@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3> Barang</h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Barang</h2>

                    <div class="clearfix"></div>
                </div>
                {{-- <div class="x_content"> --}}
                <div class="card">
                    <div class="card-body">
                        <a href="/detail_foto/{{ $detail_foto->id_barang }}" class="btn btn-primary">Kembali</a>
                        <form action="/update_detail_foto/{{ $detail_foto->id  }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src="{{ asset('produk/' .$detail_foto->foto ) }}" alt="..."id="gambar-preview" class="w-50 h-auto">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label class=" col-form-label">keterangan</label>
                                                <input type="text" class="form-control" name="keterangan" value="{{ $detail_foto->keterangan }}">
                
                                            </div>
                                            
                                            <input type="file" class="form-control-file" id="gambar" name="gambar"
                                                accept="image/*" onchange="previewImage(this);">
                                                <button type="submit">Simpan</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>



                    </div>
                </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>







    <script>
        // function edit(data) {
        //     console.log(data);
        //     document.getElementById("id_edit").value = data.id;
        //     document.getElementById("nama_barang").value = data.nama_barang;
        //     document.getElementById("deskripsi").value = data.deskripsi;

        //     // Select the correct option in the jenis_barang_select
        //     const jenisBarangSelect = document.getElementById("jenis_barang_select");
        //     for (let i = 0; i < jenisBarangSelect.options.length; i++) {
        //         if (jenisBarangSelect.options[i].value == data.id_jenis) {
        //             jenisBarangSelect.selectedIndex = i;
        //             break;
        //         }
        //     }
        // }

        function previewImage(input) {
            var preview = document.getElementById('gambar-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Tampilkan gambar terpilih
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none'; // Sembunyikan gambar jika tidak ada file yang dipilih
            }
        }
    </script>
@endsection
