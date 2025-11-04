@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    
                    <p>Name: {{ Auth::user()->nama }}</p>
                    <p>Email: {{ Auth::user()->email }}</p>
                    
                    @if(session('role') == 'mahasiswa')
                        <p>NIM: {{ Auth::user()->nim }}</p>
                        <p>Role: Mahasiswa</p>
                    @elseif(session('role') == 'konselor')
                        <p>ID Konselor: {{ Auth::user()->Idkonselor }}</p>
                        <p>Role: Konselor</p>
                    @endif
                    
                    <p>Account created: {{ Auth::user()->created_at->diffForHumans() }}</p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection