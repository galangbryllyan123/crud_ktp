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
                <h1>Data User</h1>
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
                            <h3 class="card-title">Data Data User</h3>
                        </div>
                        <div class="card-body">
                            <style>
                                .data-table td, .data-table th{
                                    white-space: nowrap;
                                }
                            </style>
                            <div class="table-responsive">
                                <table class="table table-bordered data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Verified At</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <td></td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->email_verified_at)
                                                    {{ $user->email_verified_at->diffForHumans() }}
                                                @else
                                                    <div class="badge badge-danger">not verified</div>
                                                @endif
                                            </td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                            <td>{{ $user->created_at }}</td>
                                        @endforeach
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
            "order": [
                [1, "asc"]
            ],
            "columnDefs": [{
                "targets": [0, 5],
                "orderable": false
            }],
        });
        table.on('order.dt search.dt', function () {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
  </script>
@endpush