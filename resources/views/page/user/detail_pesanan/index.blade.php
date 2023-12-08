@extends('layouts.base_user.base_dashboarduser')

@section('judul', 'List Detail Pesanan')

@section('script_head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Detail Pesanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active">Detail Pesanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0" style="margin: 20px">
                <table id="previewDetailPesanan" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ID Pesanan</th>
                            <th>ID Makanan</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('script_footer')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#previewDetailPesanan').DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "{{ route('user.detail-pesanan.user.showDetailPesanan') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    },
                    "error": function (xhr, error, thrown) {
                        console.error('DataTables Ajax Error:', xhr, error, thrown);
                        // Handle errors more gracefully, e.g., display a user-friendly message
                    }
                },
                "columns": [
                    { "data": "idDetail" },
                    { "data": "idPesanan" },
                    { "data": "idMakanan" },
                    { "data": "hargasatuan" },
                    { "data": "jumlah" },
                    { "data": "total" },
                    // { 
                    //     "data": "options",
                    //     "orderable": false,
                    //     "searchable": false
                    // },
                ],
                "language": {
                    // ... Your language settings ...
                },
                "error": function (xhr, error, thrown) {
                    console.error('DataTables Error:', xhr, error, thrown);
                    // Handle errors more gracefully, e.g., display a user-friendly message
                }
            });

            // hapus data
            $('#previewDetailPesanan').on('click', '.hapusData', function () {
                var id = $(this).data("id");
                var url = $(this).data("url");
                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: "Kamu tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                "id": id,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                Swal.fire('Terhapus!', response.msg, 'success');
                                $('#previewDetailPesanan').DataTable().ajax.reload();
                            },
                            error: function (xhr, error, thrown) {
                                console.error('Ajax Error:', xhr, error, thrown);
                                // Handle errors more gracefully, e.g., display a user-friendly message
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
