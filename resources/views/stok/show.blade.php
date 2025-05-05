@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Stok</h3>
    </div>
    <div class="card-body">
        <p><strong>Nama Barang:</strong> {{ $stok->barang->barang_nama }}</p>
        <p><strong>Tanggal:</strong> {{ $stok->stok_tanggal }}</p>
        <p><strong>Jumlah:</strong> {{ $stok->stok_jumlah }}</p>
        <p><strong>User Input:</strong> {{ $stok->user->nama }}</p>
    </div>
    <div class="card-footer">
        <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection