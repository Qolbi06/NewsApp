@extends('home.parent')

@section('content')
<div class="card p-4">
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center">
            <img class="w-75" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="ini nama user">
        </div>
        <div class="col-md-6 text-center">
            <h3>Profile</h3>
            <ul class="list-group">
                <li class="list-group-item" aria-current="true">Name : <strong>{{ auth()->user()->name }}</strong></li>
                <li class="list-group-item">E-mail Account = <strong>{{ auth()->user()->email }}</strong></li>
                <li class="list-group-item">Role Account = <strong>{{ auth()->user()->role }}</strong></li>
            </ul>
        </div>
    </div>
</div>
@endsection