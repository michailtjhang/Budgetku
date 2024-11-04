@extends('servers.layouts.app')
@section('css')
@endsection
@section('content')
    <div class="card">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role List</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
            </ol>
        </nav>
        <div class="card-body">
            <form action="{{ route('role.update', $data['role']->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Please Enter Name"
                        value="{{ $data['role']->name }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="permission">Permission</label>

                    @foreach ($data['permission'] as $row)
                        <div class="row mb-2">
                            <div class="col-md-3">
                                {{ $row['name'] }}
                            </div>
                            <div class="col-md-9">
                                <div class="row">

                                    @foreach ($row['group'] as $group)
                                        @php
                                            $checked = '';
                                        @endphp

                                        @foreach ($data['permissionRole'] as $role)
                                            @if ($role == $group['id'])
                                                @php
                                                    $checked = 'checked';
                                                @endphp
                                            @endif
                                        @endforeach

                                        <div class="col-md-3">
                                            <input type="checkbox" {{ $checked }} value="{{ $group['id'] }}"
                                                name="permission_id[]" value="{{ $group['id'] }}"
                                                id="{{ $group['id'] }}">
                                            <label class="form-check-label"
                                                for="{{ $group['id'] }}">{{ $group['name'] }}</label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach

                </div>

                <button type="submit" class="btn btn-warning">Ubah</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
@endsection
