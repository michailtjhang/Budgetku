@extends('servers.layouts.app')
@section('css')
@endsection
@section('content')
    <div class="card">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User List</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
            </ol>
        </nav>
        <div class="card-body">
            <form action="{{ route('user.update', $data['user']->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ $data['user']->name }}" placeholder="Please Enter Name">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ $data['user']->email }}" placeholder="Please Enter Email">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Please Enter Password">
                        (Do you want to change password? Please enter new password. Otherwise leave it blank)

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="role">Role</label>

                    <select class="custom-select rounded-0 @error('role_id') is-invalid @enderror" id="role" name="role_id">
                        <option>Select</option>

                        @foreach ($data['role'] as $row)
                            <option value="{{ $row->id }}" {{ $data['user']->role_id == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                        @endforeach

                    </select>

                    @error('role_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <button type="submit" class="btn btn-warning">Ubah</button>
            </form>
        </div>
    </div>
@endsection
@section('js')
@endsection
