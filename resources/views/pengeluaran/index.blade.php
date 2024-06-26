@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3> Pengeluaran</h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Pengeluaran</h2>

                    <div class="clearfix"></div>
                </div>
                {{-- <div class="x_content"> --}}
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Tambahdata">
                            Tambah Data
                        </button>
                        <form action="" method="GET" class="form-inline ml-2" id="searchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="searchInput"
                                    value="{{ Request()->search }}" placeholder="Cari Data Pengeluaran..."
                                    oninput="searchOnChange()">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    <a href="/pengeluaran" class="btn btn-success">refresh</a>
                                </div>
                            </div>
                        </form>

                        {{-- <a href="/tambah_barang" class="btn btn-primary">Tambah Barang</a> --}}

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Tanggal</th>
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


                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ $item->nominal }}</td>
                                            <td>{{ $item->tanggal }}</td>
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
                    <form action="{{ route('pengeluaran.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Nominal</label>
                                <input type="text" class="form-control" name="nominal" oninput="formatCurrency(this)">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Tanggal Pengeluaran</label>
                                <input type="date" class="form-control" name="tanggal">
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
                    <form action="{{ route('pengeluaran.update_data') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_edit">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" id="keterangan">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Nominal</label>
                                <input type="text" class="form-control" name="nominal" id="nominal"
                                    oninput="formatCurrency(this)">

                            </div>
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Tanggal Pengeluaran</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal">
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
            document.getElementById("keterangan").value = data.keterangan;
            document.getElementById("nominal").value = data.nominal;
            document.getElementById("tanggal").value = data.tanggal;

            // Select the correct option in the jenis_barang_select

        }

        function formatCurrency(input) {
            let valueWithoutCommas = input.value.replace(/[,.]/g, '');
            let formattedValue = new Intl.NumberFormat('id-ID').format(valueWithoutCommas);
            input.value = formattedValue;
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
                    window.location.href = `/hapus_pengeluaran/${id}`;
                }
            });
        }
    </script>
@endsection
