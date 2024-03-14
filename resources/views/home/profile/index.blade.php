@extends('home.parent')

@section('content')
<div class="card p-4">
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center">
            @if (empty(Auth::user()->profile->image))
            <img class="w-75" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="">
            @else
                <img class="w-75" src="{{ Auth::user()->profile->image }}" alt="ini profile image">
            @endif
        </div>
        <div class="col-md-6 text-center">
            <h3>Profile</h3>
            <ul class="list-group">
                <li class="list-group-item" aria-current="true">Name : <strong>{{ auth()->user()->name }}</strong></li>
                <li class="list-group-item">E-mail Account = <strong>{{ auth()->user()->email }}</strong></li>
                <li class="list-group-item">Role Account = <strong>{{ auth()->user()->role }}</strong></li>
            </ul>
            <a href="{{ route('createProfile') }}" class="btn btn-info mt-2">
                <i class="bi bi-plus"></i>
                Create Profile
            </a>
        </div>
    </div>
</div>
@endsection