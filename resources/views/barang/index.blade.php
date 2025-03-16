@extends('layouts.template')

@section('title', 'Data Barang')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Barang</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $key => $barang)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $barang->barang_nama }}</td>
                        <td>{{ $barang->kategori->kategori_nama ?? '-' }}</td>
                        <td>{{ $barang->supplier->supplier_nama ?? '-' }}</td>
                        <td>{{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>{{ $barang->stok }}</td>
                        <td>
                            <a href="{{ route('barang.edit', $barang->barang_id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('barang.destroy', $barang->barang_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
