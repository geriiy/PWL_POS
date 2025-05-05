@extends('layouts.template')

@section('title', 'Data Stok')

@section('content')
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Data Stok</h3>
            <div class="card-tools">
                <a href="{{ url('stok/create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="stok-table" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>User Input</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#stok-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url("stok/list") }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'barang_nama', name: 'barang.barang_nama' },
                { data: 'stok_tanggal', name: 'stok_tanggal' },
                { data: 'stok_jumlah', name: 'stok_jumlah' },
                { data: 'user_nama', name: 'user.user_nama' },
            ]
        });
    });
</script>
@endpush
