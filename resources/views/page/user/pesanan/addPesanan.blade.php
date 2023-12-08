@extends('layouts.base_user.base_dashboarduser')
@section('judul', 'Tambah pesanan')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah pesanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah pesanan</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    @if(session('status'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        {{ session('status') }}
      </div>
    @endif
    <form method="post" action="{{ route('user.pesanan.user.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambahkan Pesanan</h3>

                        <div class="card-tools">
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-card-widget="collapse"
                                title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="namaPemesan">Nama Pemesan</label>
                            <input
                                type="text"
                                id="namaPemesan"
                                name="namaPemesan"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan Nama Pesanan"
                                value="{{ old('namaPemesan') }}"
                                required="required"
                                autocomplete="namaPemesan">
                            @error('namaPemesan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="namaMakanan">Nama Makanan</label>
                            <select
                                id="namaMakanan"
                                name="namaMakanan"
                                class="form-control @error('namaMakanan') is-invalid @enderror"
                                autocomplete="namaMakanan">
                            </select>
                            @error('namaMakanan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input
                                type="number"
                                id="jumlah"
                                name="jumlah"
                                class="form-control @error('jumlah') is-invalid @enderror"
                                placeholder="Masukkan Jumlah"
                                value="{{ old('jumlah') }}"
                                autocomplete="jumlah">
                            @error('jumlah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                class="form-control @error('harga') is-invalid @enderror"
                                placeholder="Harga"
                                value="{{ old('harga') }}"
                                readonly
                                autocomplete="harga">
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select
                                id="status"
                                name="status"
                                class="form-control @error('status') is-invalid @enderror"
                                autocomplete="status">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="belum_dibayar" {{ old('status') === 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                <option value="dalam_antrian" {{ old('status') === 'dalam_antrian' ? 'selected' : '' }}>Dalam Antrian</option>
                                <option value="sedang_dibuat" {{ old('status') === 'sedang_dibuat' ? 'selected' : '' }}>Sedang Dibuat</option>
                                <option value="dalam_pengiriman" {{ old('status') === 'dalam_pengiriman' ? 'selected' : '' }}>Dalam Pengiriman</option>
                                <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Additional Section for Pesanan List -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pesanan List</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Makanan</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Id Makanan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pesananList">
                                        <!-- List of added pesanan will be displayed here -->
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label for="totalHarga">Total Harga</label>
                                    <input
                                        type="number"
                                        id="totalHarga"
                                        name="totalHarga"
                                        class="form-control @error('totalHarga') is-invalid @enderror"
                                        placeholder="Total Harga"
                                        value="{{ old('totalHarga') }}"
                                        readonly
                                        required="required"
                                        autocomplete="totalHarga">
                                    @error('totalHarga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- End of Pesanan List Section -->

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('user.home') }}" class="btn btn-secondary">Cancel</a>
                <!-- Add this button to trigger adding pesanan to the list -->
                <button type="button" class="btn btn-primary float-right" onclick="addPesananToList()">Tambahkan Pesanan ke List</button>
                <button type="submit" class="btn btn-success float-right">Submit Pesanan</button>
            </div>
        </div>
    </form>
</section>
<!-- /.content -->

@endsection

@section('script_footer')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#namaMakanan').select2({
            ajax: {
                url: "{{ route('user.pesanan.user.getMakananList') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term // Menggunakan parameter 'search'
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (makanan) {
                            return {
                                id: makanan.idMakanan,
                                text: makanan.namaMakanan,
                                harga: makanan.hargaMakanan
                            };
                        })
                    };
                },
                cache: true
            }
        });

        // Mendengarkan perubahan pada input jumlah
        $('#jumlah').on('input', function () {
            // Mengambil nilai jumlah
            var jumlah = $('#jumlah').val();

            // Mengisi nilai harga berdasarkan jumlah dan hargaMakanan
            var hargaMakanan = $('#namaMakanan').select2('data')[0].harga;
            var harga = jumlah * hargaMakanan;

            // Mengisi nilai harga
            $('#harga').val(harga);
        });
    });

    // Function to add pesanan to the list
    function addPesananToList() {
        var idMakanan = $('#namaMakanan').select2('data')[0].id;
        var namaMakanan = $('#namaMakanan').select2('data')[0].text;
        var jumlah = $('#jumlah').val();
        var harga = $('#harga').val();

        // Append pesanan to the pesananList table
        $('#pesananList').append(
            '<tr>' +
                '<td><input type="hidden" name="pesananList[namaMakanan][]" value="' + namaMakanan + '">' + namaMakanan + '</td>' +
                '<td><input type="hidden" name="pesananList[jumlah][]" value="' + jumlah + '">' + jumlah + '</td>' +
                '<td><input type="hidden" name="pesananList[harga][]" value="' + harga + '">' + harga + '</td>' +
                '<td><input type="hidden" name="pesananList[idMakanan][]" value="' + idMakanan + '">' + idMakanan + '</td>' +
                '<td><button type="button" class="btn btn-danger" onclick="removePesanan(this)">Hapus</button></td>' +
            '</tr>'
        );

        // Calculate total harga and update the value of the totalHarga input
        updateTotalHarga();

        // Clear input fields after adding pesanan to the list
        $('#namaMakanan').val(null).trigger('change');
        $('#jumlah').val('');
        $('#harga').val('');
    }

    // Function to remove pesanan from the list
    function removePesanan(button) {
        // Remove the row containing the pesanan
        $(button).closest('tr').remove();

        // Recalculate total harga and update the value of the totalHarga input
        updateTotalHarga();
    }

    // Function to calculate total harga and update the value of the totalHarga input
    function updateTotalHarga() {
        var totalHarga = 0;

        // Iterate through each row in the pesananList table
        $('#pesananList tr').each(function () {
            // Get the value from the third column (harga)
            var harga = parseFloat($(this).find('td:eq(2)').text());

            // Add harga to the totalHarga
            totalHarga += harga;
        });

        // Update the value of the totalHarga input
        $('#totalHarga').val(totalHarga);
    }
</script>
@endsection
