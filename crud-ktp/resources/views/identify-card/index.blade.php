@extends('layouts.main')
@push('style-internal')
    <link rel="stylesheet" href="/template/libs/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/template/libs/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/template/libs/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kartu Tanda Penduduk</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('export') }}" class="float-lg-right btn btn-warning btn-sm"><i class="fas fa-file-csv"></i> Export CSV</a>
                    @if (auth()->user()->level != 'user')
                        <button type="button" class="float-lg-right btn btn-success btn-sm mr-2" data-toggle="modal" data-target="#modal-default"><i class="fas fa-file-import"></i> Import CSV</button>
                        <a href="{{ route('identify-card.create') }}" class="float-lg-right btn btn-primary btn-sm mr-2"><i class="fas fa-plus"></i> KTP baru</a>
                    @endif
                </div>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">Form Import KTP</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">File (.csv)</label>
                                        <input type="file" name="file" class="form-control">
                                        <a href="{{ url('template/template_import_ktp.csv') }}"><small>download template</small></a>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </form>
                        </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
              </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if (session()->has('success'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Sukses!</strong> {{ session('success') }}
                    </div>
                </div>
            </div>
            @endif
            @if (session()->has('erorr'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>Maaf!</strong> {{ session('error') }}
                    </div>
                </div>
            </div>
            @endif
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Kartu Tanda Penduduk</h3>
                        </div>
                        <div class="card-body">
                            <style>
                                .data-table td, .data-table th{
                                    white-space: nowrap;
                                }
                            </style>
                            <div class="table-responsive">
                                <table class="table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Kecamatan</th>
                                            <th>Desa</th>
                                            <th>Alamat</th>
                                            <th>RT</th>
                                            <th>RW</th>
                                            <th>Agama</th>
                                            <th>Status Perkawinan</th>
                                            <th>Pekerjaan</th>
                                            <th>Kewarganegaraan</th>
                                            <th width="100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@push('script-internal')
<script src="/template/libs/datatables/jquery.dataTables.min.js"></script>
<script src="/template/libs/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/template/libs/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/template/libs/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            scrollY: "500px",
            scrollX: true,
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            ajax: "{{ url('identify-card') }}",
            columns: [
                {data: 'foto', name: 'foto', 
                    render: function( data, type, full, meta ) {
                        return "<img src=\"" + data + "\" height=\"30\"/>";
                    },
                    orderable: false, searchable: false
                },
                {data: 'nik', name: 'nik'},
                {data: 'nama', name: 'nama'},
                {data: 'tempat_lahir', name: 'tempat_lahir'},
                {data: 'tgl_lahir', name: 'tgl_lahir'},
                {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                {data: 'province.name', name: 'province.name'},
                {data: 'city.name', name: 'city.name'},
                {data: 'district.name', name: 'district.name'},
                {data: 'desa', name: 'desa'},
                {data: 'alamat', name: 'alamat'},
                {data: 'rt', name: 'rt'},
                {data: 'rw', name: 'rw'},
                {data: 'agama', name: 'agama'},
                {data: 'status_perkawinan', name: 'status_perkawinan'},
                {data: 'pekerjaan', name: 'pekerjaan'},
                {data: 'kewarganegaraan', name: 'kewarganegaraan'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [
                [2, "asc"]
            ],
        });
    });
</script>
@endpush
