@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>Jenis Barang</h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Jenis Barang</h2>

                    <div class="clearfix"></div>
                </div>
                {{-- <div class="x_content"> --}}
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Tambah Data
                        </button>


                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
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
                                        <td>{{ $item->jenisbarang }}</td>
                                        {{-- <td>{{ $item->jenisbarang }}</td> --}}
                                        <td><button class="btn btn-danger"
                                                onclick="Hapus({{ $item->id }})">Hapus</button>|
                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#edit" onclick="edit({{ $item }})">
                                                Edit
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $data->withQueryString()->links() }}
                    </div>
                </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/tambah_jenis" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Jenis Barang</label>
                                <input type="text" class="form-control" name="jenisbarang">
                                {{-- <input type="hidden" name="id" id="id_edit"> --}}
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
                    <form action="/edit_jenis" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Jenis Barang</label>
                                <input type="text" class="form-control" name="jenisbarang" id="jenissbaranggg">
                                <input type="hidden" name="id" id="id_edit">
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
            document.getElementById("id_edit").value = data.id;
            document.getElementById("jenissbaranggg").value = data.jenisbarang; 
        }
        function Hapus(id) {
            // console.log("ssasas"+id);
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Apakah anda yakin ingin menghapus data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/hapus_jenisbarang/${id}`;
                }
            });
        }
    </script>
@endsection
