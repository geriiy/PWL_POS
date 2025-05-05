@extends('layouts.template')

@section('title', $page->title)

@section('breadcrumb')
    <a href="{{ route('transaksi.index') }}">Transaksi Penjualan</a> > Hapus Transaksi
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hapus Transaksi</h3>
        </div>
        <div class="card-body">
            <p>Anda yakin ingin menghapus transaksi dengan kode: <strong>{{ $transaksi->penjualan_kode }}</strong>?</p>
        </div>
        <div class="card-footer">
            <form method="POST" action="{{ route('transaksi.destroy', $transaksi->penjualan_id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
