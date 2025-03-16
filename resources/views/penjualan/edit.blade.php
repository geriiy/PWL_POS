@extends('layouts.template')

@section('content')
<div class="container">
    <h2>Edit Transaksi Penjualan</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="barang_id">ID Barang</label>
            <input type="text" class="form-control" name="barang_id" value="{{ $penjualan->barang_id }}" required>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" class="form-control" name="harga" value="{{ $penjualan->harga }}" required>
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" value="{{ $penjualan->jumlah }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
