@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>Pesanan Sudah Dikembalikan</h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pesanan Sudah Dikembalikan</h2>

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
                                    <a href="{{ route('data_transaksi_sudahdikembalikan') }}" class="btn btn-success">refresh</a>
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
                                        <th scope="col">Tanggal Kembali</th>
                                        <th scope="col">durasi</th>
                                        <th scope="col">Nama Pelanggan </th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Total Bayar Awal</th>
                                        <th scope="col">Kembalian Awal</th>
                                        <th scope="col">Model bayar</th>
                                        <th scope="col">bukti bayar awal(jika tf)</th>
                                        <th scope="col">Total Bayar akhir</th>
                                        {{-- <th scope="col">Kembalian</th> --}}
                                        <th scope="col">Model bayar</th>
                                        <th scope="col">bukti bayar akhir(jika tf)</th>
                                        
                                        <th scope="col">Total Denda</th>
                                        <th scope="col">Keterangan Denda</th>
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
                                            <td>{{ $item->tanggal_kembali }}</td>
                                            <td>{{ $item->durasi }} hari</td>
                                            <td>{{ $item->pelanggan->nama }}</td>
                                            <td>{{ number_format($item->total_harga) }}</td>
                                            <td>{{ number_format($item->bayar) }}</td>
                                            <td>{{ number_format($item->kembalian) }}</td>
                                            <td>{{ $item->model_bayar }}</td>
                                            @if ($item->bukti_bayar != null)
                                            <td><a href="{{ asset('bukti_bayarr').'/'.$item->bukti_bayar }}" class="btn btn-success">Liat bukti</a></td>
                                            @else
                                              <td>-</td>  
                                            @endif

                                            @if ($item->bayar2 > 0)
                                                <td>{{ number_format($item->bayar2) }}</td>
                                                <td>{{ $item->model_bayar2 }}</td>
                                                @if ($item->bukti_bayar2 != null)
                                                <td><a href="{{ asset('bukti_bayarr').'/'.$item->bukti_bayar2 }}" class="btn btn-success">Liat bukti</a></td>
                                                    
                                                @else
                                                   <td>-</td> 
                                                @endif
                                            @else
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            @endif
                                            {{-- <td>{{ number_format($item->kembalian) }}</td> --}}
                                           
                                            @if ($item->total_denda != null)
                                            <td>{{ number_format($item->total_denda) }}</td>
                                            <td>{{ $item->keterangan_denda }}</td>
                                                
                                            @else
                                                <td>-</td>
                                                <td>-</td>
                                            @endif
                                           
                                        
                                            {{-- <td>{{ $item->jenisbarang }}</td> --}}
                                            
                                            <td>
                                                <a href="/barang_dikembalikan/{{ $item->id }}"
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
