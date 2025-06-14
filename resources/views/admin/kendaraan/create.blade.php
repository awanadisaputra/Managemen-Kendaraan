@extends('admin.layout')

@section('content')
    <form action="{{ route('admin.kendaraan.store') }}" method="POST">
        @csrf

        @include('admin.kendaraan.form')

    </form>
@endsection