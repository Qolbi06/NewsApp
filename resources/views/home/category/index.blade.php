@extends('home.parent')

@section('content')
<div class="container">
    <div class="row card p-4">
        <h3>Category Index</h3>

        <hr>

        <div class="d-flex justify-content-end">
            <a href="{{ route('category.create') }}" class="btn btn-primary">
                <i class="bi bi-plus">Create Category</i>
            </a>
        </div>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Category</h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- menampilkan data dengan perulangan forelse dari category model --}}

                            @forelse ($category as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->slug }}</td>
                                <td>
                                    <img src="{{ $row->image }}" alt="image" width="100px">
                                </td>
                                <td>
                                {{-- Show using modal with id {{ row->id }} --}}
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal{{ $row->id }}">
                                    <i class="bi bi-eye"></i>
                                    </button>
                                    @include('home.category.include.modal-show')

                                {{-- button edit with route category.edit {{ row->id }} --}}
                                    <a href="{{ route('category.edit', $row->id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- button delete with route category.destroy {{ $row->id }} --}}
                                    <form action="{{ route('category.destroy', $row->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger d-inline">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <p>Data Masih Kosong</p>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $category->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection