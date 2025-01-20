@extends('servers.layouts.app')

@section('seoMeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <style>
        .pagination-right {
            justify-content: flex-end !important;
        }

        .info-left {
            justify-content: flex-start !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
@endsection

@section('content')
    <div class="card">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
            </ol>
        </nav>
        <div class="card-body">
            @include('_message')

            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover table-stripped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Type</th>
                            <th>Icon</th>
                            <th>Created At</th>
                            @if (!empty($data['PermissionEdit']) || !empty($data['PermissionDelete']))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th><input type="text" placeholder="Search Nama" class="form-control form-control-sm"></th>
                            <th><input type="text" placeholder="Search Type" class="form-control form-control-sm"></th>
                            <th></th>
                            <th></th>
                            @if (!empty($data['PermissionEdit']) || !empty($data['PermissionDelete']))
                                <th></th>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- /.modal-content -->
    @include('servers.category.create-modal')
    @include('servers.category.edit-modal')
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url()->current() }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type',
                        render: function(data, type, row) {
                            if (data === 'income') {
                                return '<span class="badge badge-success">Income</span>';
                            } else {
                                return '<span class="badge badge-danger">Expense</span>';
                            }
                        }
                    },
                    {
                        data: 'icon',
                        name: 'icon',
                        render: function(data) {
                            return '<i class="' + data + '"></i>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            return moment(data).format('MM-DD-YYYY');
                        }
                    },
                    @if (!empty($data['PermissionEdit']) || !empty($data['PermissionDelete']))
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    @endif
                ],
                dom: '<"d-flex justify-content-between align-items-center"<"btn-tambah"B><"search-box"f><"length-control"l>>rt<"d-flex justify-content-between align-items-center"<"info-left"i><"pagination-right"p>>',
                buttons: [
                    @if (!empty($data['PermissionAdd']))
                        {
                            text: '<i class="fas fa-plus"></i> Tambah',
                            className: 'btn btn-success btn-sm',
                            action: function(e, dt, node, config) {
                                var modal = document.getElementById('modalCreate');
                                if (modal) {
                                    var bootstrapModal = new bootstrap.Modal(modal);
                                    bootstrapModal.show();
                                } else {
                                    console.error('Modal with ID #modalCreate not found.');
                                }
                            }
                        }
                    @endif
                ],
                language: {
                    lengthMenu: "_MENU_ entries per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries available",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                }
            });

            $('#dataTable tfoot th').each(function(i) {
                var title = $('#dataTable thead th').eq(i).text();
                if ($(this).find('input').length) {
                    $('input', this).on('keyup change', function() {
                        if (table.column(i).search() !== this.value) {
                            table.column(i).search(this.value).draw();
                        }
                    });
                }
            });
        });

        function confirmDelete(deleteUrl, name) {
            Swal.fire({
                title: "Are you sure?",
                html: `This will delete <strong>${name}</strong>. This action cannot be undone.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Deleted!", response.message, "success");
                            $('#dataTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", xhr.responseJSON.message, "error");
                        }
                    });
                }
            });
        }
    </script>
@endsection
