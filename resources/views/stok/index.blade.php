@extends('layouts.template')

@section('content')
<div class="container">
    <h2>Daftar Stok Barang</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $key => $barang)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $barang->barang_nama }}</td>
                <td>{{ $barang->stok }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
