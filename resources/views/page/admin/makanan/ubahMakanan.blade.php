@extends('layouts.base_admin.base_dashboard')
@section('judul', 'Ubah Makanan')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ubah Makanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('makanan.index') }}">Makanan</a>
                    </li>
                    <li class="breadcrumb-item active">Ubah Makanan</li>
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
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Makanan</h3>
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
                            <label for="inputNamaMakanan">Nama Makanan</label>
                            <input
                                type="text"
                                id="inputNamaMakanan"
                                name="namaMakanan"
                                class="form-control @error('namaMakanan') is-invalid @enderror"
                                placeholder="Masukkan Nama Makanan"
                                value="{{ $makanan->namaMakanan }}"
                                required="required">
                            @error('namaMakanan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputHargaMakanan">Harga Makanan</label>
                            <input
                                type="text"
                                id="inputHargaMakanan"
                                name="hargaMakanan"
                                class="form-control @error('hargaMakanan') is-invalid @enderror"
                                placeholder="Masukkan Harga Makanan"
                                value="{{ $makanan->hargaMakanan }}"
                                required="required">
                            @error('hargaMakanan')
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
                <a href="{{ route('makanan.index') }}" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Ubah Makanan" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<!-- /.content -->

@endsection @section('script_footer')
<!-- Add your custom script here if needed -->
@endsection
