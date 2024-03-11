@extends('home.parent')

@section('content')
<div class="row">
    <div class="card p-4">
        <h3>News Index</h3>

        <hr>

        <div class="d-flex justify-content-end">
            <a href="{{ route('news.create') }}" class="btn btn-primary">
                <i class="bi bi-plus">Create News</i>
            </a>
        </div>

        @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
        @endif

        <div class="container mt-3">
            <div class="card p-3">
                <h5 class="card-title">Data News</h5>
                <table class="tabel datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Image News</th>
                            <th>Image Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($news as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->category->name }}</td>
                        <td>
                            <img src="{{ $row->image }}" width="100px" alt="img" srcset="">
                        </td>
                        <td>
                            <img src="{{ $row->category->image }}" alt="image" width="100px">
                        </td>
                        <td>
                            <a href="{{ route('news.show', $row->id) }}" class="btn btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('news.edit', $row->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('news.destroy', $row->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <p class="text-center">
                            data masih kosong
                        </p>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>   
</div>
@endsection