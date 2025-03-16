@extends('layouts.template')
@section('content')
<div class="container">
    <h2>Data Stok Barang</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah Stok</th>
                <th>Tanggal Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stok as $item)
            <tr>
                <td>{{ $item->barang_nama }}</td>
                <td>{{ $item->stok_jumlah }}</td>
                <td>{{ $item->stok_tanggal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection