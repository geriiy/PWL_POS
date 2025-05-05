@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Stok</h3>
    </div>
    <form action="{{ route('stok.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="barang_id">Barang</label>
                <select name="barang_id" id="barang_id" class="form-control" required>
                    <option value="">Pilih Barang</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="stok_tanggal">Tanggal</label>
                <input type="datetime-local" name="stok_tanggal" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stok_jumlah">Jumlah</label>
                <input type="number" name="stok_jumlah" class="form-control" min="1" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('stok.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection