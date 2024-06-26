@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3> </h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Detail Foto {{ $barang->nama_barang }}</h2>

                    <div class="clearfix"></div>
                </div>
                {{-- <div class="x_content"> --}}
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Tambahdata">
                            Tambah Detail Foto
                        </button>

                        <a href="/barang" class="btn btn-danger">Kembali</a>
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>

                                    <th scope="col">keterangan</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Aksi</th>

                                </tr>
                            </thead>



                            <tbody>


                                @foreach ($detal_foto as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>


                                        <td>{{ $item->keterangan }}</td>
                                        <td> <img src="{{ asset('produk/' . $item->foto) }}"
                                                style="width: 70px; height: 70px; object-fit: cover;" alt=""
                                                class="rounded-circle"></td>

                                        {{-- <td>{{ $item->jenisbarang }}</td> --}}
                                        <td><button class="btn btn-danger"
                                                onclick="Hapus({{ $item->id }})">Hapus</button>|
                                            <a href="/edit_detail_foto/{{ $item->id }}" class="btn btn-warning">Edit</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>






    <div class="modal fade" id="Tambahdata" tabindex="-1" aria-labelledby="TambahdataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TambahdataLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/tambah_detail_foto" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" id="nama_barang">
                                <input type="hidden" name="id_barang" value="{{ $barang->id }}">
                            </div>


                            <div class="form-group mb-3">
                                <label class=" col-form-label">Upload Foto</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="gambar" name="gambar"
                                        accept="image/*" onchange="previewImage(this);">

                                    <label class="custom-file-label" for="gambar"
                                        aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group m-3">

                                <div class="col-md-4">
                                    <img src="" alt="..."id="gambar-preview" class="w-50 h-auto">
                                </div>
                            </div>



                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
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

        function Hapus(id) {
            // console.log("ssasas"+id);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/hapus_detail_foto/${id}`;
                }
            });
        }
    </script>
@endsection
