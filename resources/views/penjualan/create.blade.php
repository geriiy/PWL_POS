@extends('layouts.template')

@section('content')
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <h4>Tambah Transaksi Penjualan</h4>
            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="barang_id">Pilih Barang:</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->id }}">{{ $b->nama_barang }} - Rp {{ number_format($b->harga, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
