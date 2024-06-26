@extends('tes')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>Tambah Barang</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Tambah Barang</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="/store_barang" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="Nama-barang">Nama
                                    Barang</label>
                                <div class="col-md-8 col-sm-8">
                                    <input type="text" id="Nama-barang" name="nama_barang" required="required"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="jenis_barang">Jenis
                                    Barang</label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control" name="id_jenis">
                                        @foreach ($jenis_barang as $item)
                                            <option value="{{ $item->id }}">{{ $item->jenisbarang }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="deskripsi">Deskripsi
                                    Barang</label>
                                <div class="col-md-8 col-sm-8">
                                    <textarea id="deskripsi" required="required" class="form-control" name="deskripsi" data-parsley-trigger="keyup"
                                        data-parsley-minlength="20" data-parsley-maxlength="100"
                                        data-parsley-minlength-message="Come on! You need to enter at least a 20 characters long comment."
                                        data-parsley-validation-threshold="10"></textarea>
                                </div>
                            </div>
                            <div id="dynamic-inputs">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="ukuran">Ukuran</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="text" id="ukuran" name="ukuran[]" required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="warna">Warna</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="text" id="warna" name="warna[]" required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="stok">Stok</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="number" id="stok" name="stok[]" required="required"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="harga">Harga</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="text" id="harga" name="harga[]" required="required"
                                            class="form-control" oninput="formatCurrency(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="item form-group">
                                <div class="col-md-8 col-sm-8 offset-md-3">
                                    <button type="button" class="btn btn-primary"
                                        onclick="addInput()">Tambah</button><span>tambah ukuran,warna,stok, dan harga</span>
                                </div>
                            </div>
                            <div id="dynamic-image-inputs">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="gambar">Gambar</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="file" class="form-control-file" id="gambar" name="gambar[]"
                                            accept="image/*">
                                        <img id="gambar-preview" src="#" alt="Gambar Pratinjau"
                                            style="max-width: 50%; display: none;">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="keterangan">Keterangan Gambar</label>
                                    <div class="col-md-8 col-sm-8">
                                        <input type="text" id="keterangan" name="keterangan[]" required="required"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="item form-group">
                                <div class="col-md-8 col-sm-8 offset-md-3">
                                    <button type="button" class="btn btn-primary" onclick="addImageInput()">Tambah Gambar</button>
                                </div>
                            </div>

                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function addInput() {
            const dynamicInputs = document.getElementById('dynamic-inputs');

            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group';

            // Ukuran
            const ukuranLabel = document.createElement('label');
            ukuranLabel.className = 'col-form-label col-md-3 col-sm-3 label-align';
            ukuranLabel.innerHTML = 'Ukuran';
            const ukuranDiv = document.createElement('div');
            ukuranDiv.className = 'col-md-8 col-sm-8';
            const ukuranInput = document.createElement('input');
            ukuranInput.type = 'text';
            ukuranInput.name = 'ukuran[]';
            ukuranInput.className = 'form-control';
            ukuranInput.required = true;
            ukuranDiv.appendChild(ukuranInput);

            // Warna
            const warnaLabel = document.createElement('label');
            warnaLabel.className = 'col-form-label col-md-3 col-sm-3 label-align';
            warnaLabel.innerHTML = 'Warna';
            const warnaDiv = document.createElement('div');
            warnaDiv.className = 'col-md-8 col-sm-8';
            const warnaInput = document.createElement('input');
            warnaInput.type = 'text';
            warnaInput.name = 'warna[]';
            warnaInput.className = 'form-control';
            warnaInput.required = true;
            warnaDiv.appendChild(warnaInput);

            // Stok
            const stokLabel = document.createElement('label');
            stokLabel.className = 'col-form-label col-md-3 col-sm-3 label-align';
            stokLabel.innerHTML = 'Stok';
            const stokDiv = document.createElement('div');
            stokDiv.className = 'col-md-8 col-sm-8';
            const stokInput = document.createElement('input');
            stokInput.type = 'number';
            stokInput.name = 'stok[]';
            stokInput.className = 'form-control';
            stokInput.required = true;
            stokDiv.appendChild(stokInput);

            // Harga
            const hargaLabel = document.createElement('label');
            hargaLabel.className = 'col-form-label col-md-3 col-sm-3 label-align';
            hargaLabel.innerHTML = 'Harga';
            const hargaDiv = document.createElement('div');
            hargaDiv.className = 'col-md-8 col-sm-8';
            const hargaInput = document.createElement('input');
            hargaInput.type = 'text';
            hargaInput.name = 'harga[]';
            hargaInput.className = 'form-control';
            hargaInput.required = true;
            hargaInput.oninput = function() {
                formatCurrency(this);
            };
            hargaDiv.appendChild(hargaInput);

            // Remove button
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger';
            removeButton.innerHTML = 'Hapus';
            removeButton.onclick = function() {
                inputGroup.remove();
            };

            inputGroup.appendChild(ukuranLabel);
            inputGroup.appendChild(ukuranDiv);
            inputGroup.appendChild(warnaLabel);
            inputGroup.appendChild(warnaDiv);
            inputGroup.appendChild(stokLabel);
            inputGroup.appendChild(stokDiv);
            inputGroup.appendChild(hargaLabel);
            inputGroup.appendChild(hargaDiv);
            inputGroup.appendChild(removeButton);

            dynamicInputs.appendChild(inputGroup);
        }
 function addImageInput() {
            const dynamicImageInputs = document.getElementById('dynamic-image-inputs');

            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group';

            // Gambar
            const gambarLabel = document.createElement('label');
            gambarLabel.className = 'col-form-label col-md-3 col-sm-3 label-align';
            gambarLabel.innerHTML = 'Gambar';
            const gambarDiv = document.createElement('div');
            gambarDiv.className = 'col-md-8 col-sm-8';
            const gambarInput = document.createElement('input');
            gambarInput.type = 'file';
            gambarInput.name = 'gambar[]';
            gambarInput.className = 'form-control-file';
            gambarInput.accept = 'image/*';
           
            gambarDiv.appendChild(gambarInput);

            // Keterangan Gambar
            const keteranganLabel = document.createElement('label');
            keteranganLabel.className = 'col-form-label col-md-3 col-sm-3 label-align';
            keteranganLabel.innerHTML = 'Keterangan Gambar';
            const keteranganDiv = document.createElement('div');
            keteranganDiv.className = 'col-md-8 col-sm-8';
            const keteranganInput = document.createElement('input');
            keteranganInput.type = 'text';
            keteranganInput.name = 'keterangan[]';
            keteranganInput.className = 'form-control';
            keteranganInput.required = true;
            keteranganDiv.appendChild(keteranganInput);

            // Remove button
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger';
            removeButton.innerHTML = 'Hapus';
            removeButton.onclick = function() {
                inputGroup.remove();
            };

            inputGroup.appendChild(gambarLabel);
            inputGroup.appendChild(gambarDiv);
            inputGroup.appendChild(keteranganLabel);
            inputGroup.appendChild(keteranganDiv);
            inputGroup.appendChild(removeButton);

            dynamicImageInputs.appendChild(inputGroup);
        }
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

        function formatCurrency(input) {
            let valueWithoutCommas = input.value.replace(/[,.]/g, '');
            let formattedValue = new Intl.NumberFormat('id-ID').format(valueWithoutCommas);
            input.value = formattedValue;
        }
    </script>
@endsection
