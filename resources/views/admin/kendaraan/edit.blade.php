@extends('admin.layout')

@section('content')

    <form action="{{ route('admin.kendaraan.update', $kendaraan->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.kendaraan.form', ['kendaraan' => $kendaraan])

    </form>
@endsection