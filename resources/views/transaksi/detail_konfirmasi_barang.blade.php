@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3> Detail Barang pesanan</h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Detail Barang Pesanan</h2>

                    <div class="clearfix"></div>
                </div>
                {{-- <div class="x_content"> --}}
                <div class="card">
                    <div class="card-body">
                    
                        <a href="{{ route('transaksi_pembayaran') }}" class="btn btn-danger">Kembali</a>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>

                                        <th scope="col">id transaksi</th>
                                        <th scope="col">nama barang</th>
                                        <th scope="col">ukuran</th>
                                        <th scope="col">warna</th>
                                        <th scope="col">harga</th>
                                        <th scope="col">qty</th>
                                        <th scope="col">subtotal harga</th>
                                        {{-- <th scope="col">Aksi</th> --}}

                                    </tr>
                                </thead>



                                <tbody>


                                    @foreach ($data as $item)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>


                                            <td>{{ $item->id_transkasi }}</td>
                                            <td>{{ $item->detail_barang->barang->nama_barang }}</td>
                                            <td>{{ $item->detail_barang->ukuran }}</td>
                                            <td>{{ $item->detail_barang->warna }}</td>
                                            <td>{{ number_format($item->detail_barang->harga) }}</td>
                                            <td>{{ $item->qty }}</td>
                                            {{-- <td>{{ $item->jenisbarang }}</td> --}}
                                            <td>{{ number_format($item->subtotal_harga) }}</td>
                                            

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






    
    {{-- <script>
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
    </script> --}}
@endsection
