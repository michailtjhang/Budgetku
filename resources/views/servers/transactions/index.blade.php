@extends('servers.layouts.app')

@section('css')
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection

@section('content')
    <!-- Card for Transactions -->
    <div class="card">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
            </ol>
        </nav>
        <div class="col-12">

            @include('_message')

            <div class="card-header">
                <h3 class="card-title">Transaction List</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-create">
                    <i class="fas fa-plus"></i> Add Transaction
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <!-- Column for Expenses -->
                    <div class="col-md-6 col-12">
                        <h5>Expenses</h5>
                        <div class="list-group">
                            @foreach ($expenses as $transaction)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="w-75">
                                        <h6 class="mb-1 font-weight-bold">{{ $transaction->category->name }}</h6>
                                        <small class="text-muted">{{ $transaction->description }}</small>
                                    </div>
                                    <div class="w-25 text-right">
                                        <h6 class="text-danger mb-0">${{ number_format($transaction->amount, 2) }}</h6>
                                        <small class="text-muted">{{ $transaction->date }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Column for Income -->
                    <div class="col-md-6 col-12">
                        <h5>Income</h5>
                        <div class="list-group">
                            @foreach ($income as $transaction)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="w-75">
                                        <h6 class="mb-1 font-weight-bold">{{ $transaction->category->name }}</h6>
                                        <small class="text-muted">{{ $transaction->description }}</small>
                                    </div>
                                    <div class="w-25 text-right">
                                        <h6 class="text-success mb-0">Rp.{{ number_format($transaction->amount, 2) }}</h6>
                                        <small class="text-muted">{{ $transaction->date }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="pagination justify-content-center my-4">
                    {{ $income->links() }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.card -->

    <!-- Create Modal -->
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="modal-createLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('transaction.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-createLabel">Add Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('servers.transactions.partials.form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-editLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-editLabel">Edit Transaction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- @include('servers.transactions.partials.form') --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://adminlte.io/themes/v3/plugins/select2/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: "Select an option",
                allowClear: true
            });

            // Handle Edit Button Click
            $('.edit-btn').on('click', function() {
                let id = $(this).data('id');
                $('#edit-form').attr('action', `/transaction/${id}`);
                $('#edit-form select[name="category_id"]').val($(this).data('category')).trigger('change');
                $('#edit-form input[name="date"]').val($(this).data('date'));
                $('#edit-form input[name="amount"]').val($(this).data('amount'));
                $('#edit-form textarea[name="description"]').val($(this).data('description'));
                $('#edit-form select[name="type"]').val($(this).data('type')).trigger('change');
            });
        });
    </script>
@endsection
