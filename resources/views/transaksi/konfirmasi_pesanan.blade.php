@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3> Konfirmasi pesanan</h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Konfirmasi pesanan</h2>

                    <div class="clearfix"></div>
                </div>
                {{-- <div class="x_content"> --}}
                <div class="card">
                    <div class="card-body">

                        <form action="" method="GET" class="form-inline ml-2" id="searchForm">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="searchInput"
                                    value="{{ Request()->search }}" placeholder="Cari Data transaksi..."
                                    oninput="searchOnChange()">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                    <a href="{{ route('transaksi_belumterkonfirmasi') }}" class="btn btn-success">refresh</a>
                                </div>
                            </div>
                        </form>



                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tanggal sewa</th>
                                        <th scope="col">Tanggal Akhir</th>
                                        <th scope="col">durasi</th>
                                        <th scope="col">Nama Pelanggan </th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Status Konfirmasi</th>
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


                                            <td>{{ $item->tanggal_sewa }}</td>
                                            <td>{{ $item->tanggal_akhir }}</td>
                                            <td>{{ $item->durasi }}</td>
                                            <td>{{ $item->pelanggan->nama }}</td>
                                            <td>{{ number_format($item->total_harga) }}</td>
                                            {{-- <td>{{ $item->jenisbarang }}</td> --}}
                                            <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#edit" onclick="edit({{ $item }})">
                                                    Konfirmasi
                                                </button>
                                            </td>
                                            <td>
                                                <a href="/detail_transaksi_konfirmasi/{{ $item->id }}"
                                                    class="btn btn-success">Detail
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
                    <form action="{{ route('konfirmasi_pesanan') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class=" col-form-label">Konfirmasi Pesanan</label>
                                <select class="custom-select" name="status_konfirmasi"
                                    aria-label="Example select with button addon">

                                    <option value="sudah_terkonfirmasi">Konfirmasi</option>
                                    <option value="tidak_terkonfirmasi">Tolak</option>

                                </select>

                                <input type="hidden" name="id" id="id_edit">
                            </div>{{-- <div class="form-group mb-3">
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
