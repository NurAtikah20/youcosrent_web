@extends('tes')

@section('content')
    <style>
        .decrease-icon {
            transform: scaleY(-1);
        }

        .icon i {
            font-size: 0.8em;
            /* Sesuaikan ukuran sesuai kebutuhan Anda */
        }
    </style>
    <div class="page-title">
        <div class="title_left">
            <h3> Pembukuan</h3>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12  ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Pembukuan</h2>

                    <div class="clearfix"></div>
                </div>
                {{-- <div class="x_content"> --}}
                <div class="card">
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="" class="form-label">Dari Tanggal</label>
                                <input type="date" class="form-control" name="dariTanggal" id="tglMulai"
                                    value="{{ $tanggalawal }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="" class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" name="sampaiTanggal" id="tglSelesai"
                                    value="{{ $tanggalakhir }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="btn-cetak" class="form-label">&nbsp;</label><br>
                                <a href="" class="btn btn-primary" id="btn-cetak"
                                    onclick="this.href='/pembukuan/'+document.getElementById('tglMulai').value + '/' + document.getElementById('tglSelesai').value">Proses</a>
                                    <a href="/pembukuan" class="btn btn-success">refresh</a>
                                <!-- Button trigger modal -->
                                {{-- <button type="button" class="btn-cetak btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Cetak Excel
                                </button> --}}

                                <!-- Modal -->

                            </div>

                        </div>
                        <div class="row">

                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa-solid fa-wallet"></i>
                                    </div>
                                    <div class="count">{{ number_format($pendapatan) }}</div>

                                    <h3> Jumlah Pemasukan</h3>
                                    <p>Lorem ipsum psdea itgum rixt.</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa-solid fa-calculator"></i>
                                    </div>
                                    <div class="count fs-6">{{ number_format($pengeluaran) }}</div>

                                    <h3>Jumlah Pengeluaran</h3>
                                    <p>Lorem ipsum psdea itgum rixt.</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-line-chart"></i>
                                    </div>
                                    <div class="count">{{ number_format($laba) }}</div>

                                    <h3>Pendapatan Laba</h3>
                                    <p>Lorem ipsum psdea itgum rixt.</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-line-chart decrease-icon"></i>

                                    </div>
                                    <div class="count">{{ number_format($kerugian) }}</div>

                                    <h3>Jumlah Kerugian</h3>
                                    <p>Lorem ipsum psdea itgum rixt.</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>
@endsection
