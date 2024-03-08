@extends('home.parent')

@section('content')
<div class="row">
    <div class="card p-4">
        <h5 class="card-title">
            {{ $news->title }} - <span class="badge rounded-pill bg-info text-white">{{ $news->category->name }}</span>
        </h5>

        <hr>
        
        <p>
            <img src="{{ $news->image }}" alt="ini gambar berita" class="img-fluid">
        </p>

        <div id="editor">
            {!! $news->content !!}
        </div>

        <script>
            ClassicEditor
                    .create( document.querySelector( '#editor' ) )
                    .then( editor => {
                            console.log( editor );
                    } )
                    .catch( error => {
                            console.error( error );
                    } );
        </script>

        <div class="container mt-2">
            <div class="d-flex justify-content-end">
                <a href="{{ route('news.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left">Back</i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection