@extends('layouts.template')

@section('title', $page->title)

@section('breadcrumb')
    <a href="{{ route('transaksi.index') }}">Transaksi Penjualan</a> > Edit Transaksi
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Transaksi</h3>
        </div>
        <form method="POST" action="{{ route('transaksi.update', $transaksi->penjualan_id) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="penjualan_tanggal">Tanggal Transaksi</label>
                    <input type="datetime-local" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal" value="{{ $transaksi->penjualan_tanggal->format('Y-m-d\TH:i') }}" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
