@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    You are logged in!
                    
                    <p>Halo, <strong>{{ Auth::user()->nama }}</strong>!</p>
                    <p>Anda login sebagai: <strong>{{ session('role') }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection