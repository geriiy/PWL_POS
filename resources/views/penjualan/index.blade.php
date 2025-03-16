@extends('layouts.template')

@section('content')
<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <h4>Daftar Transaksi Penjualan</h4>
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Tambah Transaksi</a>
            
            

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Jumlah Barang</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan as $item)
                    <tr>
                        <td>{{ $item->penjualan_id }}</td>
                        <td>{{ $item->barang->nama_barang ?? 'Barang Tidak Ditemukan' }}</td>
                        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('penjualan.edit', $item->penjualan_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            
                            <!-- Form Hapus -->
                            <form action="{{ route('penjualan.destroy', $item->penjualan_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody>
                    @foreach ($penjualan as $p)
                        <tr>
                            <td>{{ $p->penjualan_id }}</td>
                            <td>{{ $p->tanggal }}</td>
                            <td>{{ $p->details->sum('jumlah') }}</td>
                            <td>Rp {{ number_format($p->details->sum(fn($d) => $d->harga * $d->jumlah), 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('penjualan.destroy', $p->penjualan_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
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
