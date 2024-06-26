@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3> Detail Barang</h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Detail Barang {{ $barang->nama_barang }}</h2>

                    <div class="clearfix"></div>
                </div>
                {{-- <div class="x_content"> --}}
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahdata">
                            Tambah Data
                        </button>
                        <a href="/barang" class="btn btn-danger">Kembali</a>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>

                                        <th scope="col">ukuran</th>
                                        <th scope="col">warna</th>
                                        <th scope="col">harga</th>
                                        <th scope="col">stok</th>
                                        <th scope="col">Aksi</th>

                                    </tr>
                                </thead>



                                <tbody>


                                    @foreach ($detailBarang as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>


                                            <td>{{ $item->ukuran }}</td>
                                            <td>{{ $item->warna }}</td>
                                            <td>{{ number_format($item->harga) }}</td>
                                            <td>{{ $item->stok }}</td>
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
                        </div>
                        {{-- {{ $detailBarang->withQueryString()->links() }} --}}
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
                    <form action="/edit_detailbarang" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Ukuran</label>
                                <input type="text" class="form-control" name="ukuran" id="ukuran">
                                <input type="hidden" name="id" id="id_edit">
                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Warna</label>
                                <input type="text" class="form-control" name="warna" id="warna">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">stok</label>
                                <input type="number" class="form-control" name="stok" id="stok">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">harga</label>
                                <input type="text" class="form-control" name="harga" id="harga"
                                    oninput="formatCurrency(this)">

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
    <div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="tambahdataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahdataLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/tambah_detailbarang" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Ukuran</label>
                                <input type="text" class="form-control" name="ukuran">
                                <input type="hidden" name="id_barang" value="{{ $barang->id }}">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Warna</label>
                                <input type="text" class="form-control" name="warna">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">stok</label>
                                <input type="number" class="form-control" name="stok">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">harga</label>
                                <input type="text" class="form-control" name="harga"
                                    oninput="formatCurrency(this)">

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
        function edit(data) {
            console.log(data);
            document.getElementById("id_edit").value = data.id;
            document.getElementById("ukuran").value = data.ukuran;
            document.getElementById("warna").value = data.warna;
            document.getElementById("stok").value = data.stok;
            document.getElementById("harga").value = data.harga;

            // Select the correct option in the jenis_barang_select

        }

        function Hapus(id) {
            // console.log("ssasas"+id);
            Swal.fire({
                title: "Apakah Kamu Yakin?",
                text: "Apakah Kamu yakin Inign menghapus detail barang ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `/hapus_detailbrg/${id}`;
                }
            });
        }


        function formatCurrency(input) {
            let valueWithoutCommas = input.value.replace(/[,.]/g, '');
            let formattedValue = new Intl.NumberFormat('id-ID').format(valueWithoutCommas);
            input.value = formattedValue;
        }
    </script>
@endsection
