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
                      
                            <form action="" method="GET" class="form-inline ml-2" id="searchForm">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" id="searchInput"
                                        value="{{ Request()->search }}" placeholder="Cari Data Barang..."
                                        oninput="searchOnChange()">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                        <a href="/barang" class="btn btn-success">refresh</a>
                                    </div>
                                </div>
                            </form>
                        
                        <a href="/tambah_barang" class="btn btn-primary">Tambah Barang</a>

<div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">deskripsi</th>
                                    <th scope="col">Jenis Barang</th>
                                    <th scope="col">Aksi</th>

                                </tr>
                            </thead>



                            <tbody>
                                @php
                                    $offset = ($data->currentPage() - 1) * $data->perPage();
                                @endphp

                                @foreach ($data as $item)
                                    <tr>
                                        <th scope="row">{{ $offset + $loop->iteration }}</th>


                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>{{ $item->jenisbarang->jenisbarang }}</td>
                                        {{-- <td>{{ $item->jenisbarang }}</td> --}}
                                        <td><button class="btn btn-danger"
                                                onclick="Hapus({{ $item->id }})">Hapus</button>|
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#edit" onclick="edit({{ $item }})">
                                                Edit
                                            </button>
                                            <a href="/detail_foto/{{ $item->id }}"
                                                class="btn btn-success">Detail Foto</a>
                                            <a href="/detail_barang/{{ $item->id }}" class="btn btn-success">Detail
                                                Barang</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data->withQueryString()->links() }}
                    </div>
                    </div>
                </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>






    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/edit_barang" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Nama Barang</label>
                                <input type="text" class="form-control" name="nama_barang" id="nama_barang">
                                <input type="hidden" name="id" id="id_edit">
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Jenis Barang</label>
                                <select class="custom-select" name="id_jenis" id="jenis_barang_select"
                                    aria-label="Example select with button addon">
                                    @foreach ($jenis_barang as $item)
                                        <option value="{{ $item->id }}">{{ $item->jenisbarang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class=" col-form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                            </div>
                            {{-- <div class="form-group mb-3">
                                <label class=" col-form-label">Upload File Pengumuman</label>

                                <input type="file" class="form-control"name="file_pngmm" accept=".pdf">
                            </div> --}}


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
        function edit(data) {
            console.log(data);
            document.getElementById("id_edit").value = data.id;
            document.getElementById("nama_barang").value = data.nama_barang;
            document.getElementById("deskripsi").value = data.deskripsi;

            // Select the correct option in the jenis_barang_select
            const jenisBarangSelect = document.getElementById("jenis_barang_select");
            for (let i = 0; i < jenisBarangSelect.options.length; i++) {
                if (jenisBarangSelect.options[i].value == data.id_jenis) {
                    jenisBarangSelect.selectedIndex = i;
                    break;
                }
            }
        }

        function Hapus(id) {
            // console.log("ssasas"+id);
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/hapus_barang/${id}`;
                }
            });
        }
    </script>
@endsection
