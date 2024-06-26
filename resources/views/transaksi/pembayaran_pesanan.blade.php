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
                                    <a href="{{ route('transaksi_belumterkonfirmasi') }}"
                                        class="btn btn-success">refresh</a>
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
                                        <th scope="col">Bayar</th>
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
                                                    Bayar
                                                </button>
                                            </td>
                                            <td>
                                                <a href="/detail_transaksi_barang/{{ $item->id }}"
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
                    <h5 class="modal-title" id="editLabel">Bayar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengembalian_dan_bayar') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label class="col-form-label">Total Harga</label>
                                <input type="text" class="form-control" name="total_harga" id="total_harga" readonly>
                                <input type="hidden" name="id" id="id_edit">
                                <input type="hidden" name="total_harga1" id="total_harga1">
                                <input type="hidden" name="kurang_bayar1" id="kurang_bayar1">
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label">Kurang Bayar</label>
                                <input type="text" class="form-control" name="kurang_bayar" id="kurang_bayar" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label">Bayar Awal</label>
                                <input type="text" class="form-control" name="bayar1" id="bayar1" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label">Kembalian Awal</label>
                                <input type="text" class="form-control" name="kembalian1" id="kembalian1" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label">Denda</label>
                                <input type="text" class="form-control" name="total_denda" id="total_denda"
                                    oninput="validateAndUpdateDenda(this)">
                                <span>Jika ada denda</span>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label">Keterangan Denda</label>
                                <textarea name="keterangan_denda" cols="30" rows="10" class="form-control"></textarea>
                                <span>Jika ada denda</span>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label">Bayar</label>
                                <input type="text" class="form-control" name="bayar" id="bayar" value="0"
                                    oninput="validateAndFormatCurrency(this)">
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label">Kembalian</label>
                                <input type="text" class="form-control" name="kembalian" id="kembalian"     value="0" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label">Model Pembayaran</label>
                                <select name="model_bayar" id="model_bayar" class="form-control">
                                    <option value="cod">CASH</option>
                                    <option value="tf">TF</option>
                                </select>
                            </div>
                            <div class="form-group mb-3"  id="bukti_bayar_input">
                                <label class="col-form-label">Bukti bayar</label>
                                <input type="file" class="form-control" name="bukti_bayar">
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
            //fungsi untuk ketika model pembayaran berubah
        function toggleBuktiBayar() {
            var modelPembayaran = document.getElementById("model_bayar").value;
            var buktiBayar = document.getElementById("bukti_bayar_input");
            if (modelPembayaran === "tf") {
                buktiBayar.style.display = "block";
            } else {
                buktiBayar.style.display = "none";
                buktiBayar.value = ""; // Set nilai menjadi null jika model pembayaran bukan TF
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state
            toggleBuktiBayar();
            // Add event listener to dropdown
            document.getElementById("model_bayar").addEventListener("change", toggleBuktiBayar);
        });


            function formatCurrency(value) {

                return value.toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
            }

            function parseCurrency(value) {
                return parseFloat(value.replace(/\./g, '').replace(/,/g, '.')) || 0;
            }

            function formatRp(data) {
                var value = data.value.replace(/[^0-9]/g, '');

                if (value) {
                    value = parseInt(value).toLocaleString('id-ID');
                }

                data.value = value;
            }

            function formatAndCalculateValues() {
                const totalHarga = parseCurrency(document.getElementById('total_harga').value);
                const totalDenda = formatCurrency(document.getElementById('total_denda').value);
                const bayar = parseCurrency(document.getElementById('bayar').value);
                const kurangBayar = parseCurrency(document.getElementById('kurang_bayar').value);

                document.getElementById('kurang_bayar').value = formatCurrency(kurangBayar > 0 ? kurangBayar : 0);

                const kembalian = bayar - kurangBayar;
                document.getElementById('kembalian').value = formatCurrency(kembalian > 0 ? kembalian : 0);

                document.getElementById('bayar').value = formatCurrency(bayar);
            }

            function validateAndFormatCurrency(input) {
                // Hanya mengizinkan angka
                let value = input.value.replace(/[^\d]/g, '');

                // Memformat angka
                value = parseCurrency(value);
                input.value = formatCurrency(value);

                // Menghitung nilai-nilai terkait
                formatAndCalculateValues();
            }

            function validateAndUpdateDenda(input) {
                // Hanya mengizinkan angka
                let value = input.value.replace(/[^\d]/g, '');

                // Memformat angka
                value = parseCurrency(value);
                input.value = formatCurrency(value);

                // Mengupdate kurang bayar
                updateKurangBayar();
            }

            function updateKurangBayar() {
                const totalHarga = parseCurrency(document.getElementById('total_harga1').value);
                const kurangBayar1 = parseCurrency(document.getElementById('kurang_bayar1').value);
                const denda = parseCurrency(document.getElementById('total_denda').value);

                // Menghindari NaN dengan memberikan nilai default 0 jika NaN
                const totalHargaValid = isNaN(totalHarga) ? 0 : totalHarga;
                const kurangBayaraValid = isNaN(kurangBayar1) ? 0 : kurangBayar1;
                const dendaValid = isNaN(denda) ? 0 : denda;

                const totalHarga1 = totalHargaValid + dendaValid;
                const kurangBayar = kurangBayaraValid +
                    dendaValid; // Dalam konteks ini, kurang bayar adalah total harga dengan denda
                document.getElementById('total_harga').value = formatCurrency(totalHarga1);

                document.getElementById('kurang_bayar').value = formatCurrency(kurangBayar);
            }


            function edit(data) {
                document.getElementById("id_edit").value = data.id;
                document.getElementById("total_harga").value = data.total_harga.toLocaleString('id-ID');
                document.getElementById("bayar1").value = data.bayar.toLocaleString('id-ID');
                document.getElementById("kembalian1").value = data.kembalian.toLocaleString('id-ID');
                document.getElementById("total_harga1").value = parseInt(data.total_harga);
                document.getElementById("kurang_bayar").value = data.kurang_bayar.toLocaleString('id-ID');
                document.getElementById("kurang_bayar1").value = data.kurang_bayar.toLocaleString('id-ID');

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
