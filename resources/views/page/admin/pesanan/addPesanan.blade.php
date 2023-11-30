@extends('layouts.base_admin.base_dashboard')
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
{{-- Akhir Content Heade --}}

<!-- Main content -->
<section class="content">
    @if(session('status'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
        {{ session('status') }}
      </div>
    @endif
    <form method="post" action="{{ route('pesanan.add') }}" enctype="multipart/form-data">
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
                            <label for="totalHarga">Total Harga</label>
                            <input
                                type="number"
                                id="totalHarga"
                                name="totalHarga"
                                class="form-control @error('harga') is-invalid @enderror"
                                placeholder="Masukkan Total Harga"
                                value="{{ old('totalHarga') }}"
                                required="required"
                                autocomplete="totalHarga">
                            @error('totalHarga')
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
                                required="required"
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
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success float-right">Tambah Pesanan</button>
            </div>
        </div>
    </form>
</section>
<!-- /.content -->

@endsection

@section('script_footer')
<!-- Add your custom scripts here -->
@endsection