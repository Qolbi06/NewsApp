@extends('home.parent')

@section('content')

@if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

@if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
        @endif

<div class="row">
    <div class="card p-4">
        <h3 class="card-title">
            All User
        </h3>
        <table class="table table-bordered border-primary">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <tbody>
                    @foreach ($user as $row)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->role }}</td>
                        <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#basicModal{{ $row->id }}">
                            <i class="bi bi-pencil-square"></i>
                            Reset Password
                        </button>
                        <div class="modal fade" id="basicModal{{ $row->id }}" tabindex="-1">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Reset Password <strong>{{ $row->name }}</strong></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Default Password Become To <strong>123456</strong>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <form action="{{ route('resetPassword', $row->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-pencil-square"></i> 
                                        Reset Password
                                    </button>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div></td>
                    </tr>
                    @endforeach
                </tbody>
            </thead>
        </table>
    </div>
</div>

@endsection