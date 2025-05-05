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
                <th>Aksi</th> <!-- Kolom aksi harus sesuai -->
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
    let table = $('#stok-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("stok.list") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'barang.barang_nama', name: 'barang.barang_nama' },
            { data: 'stok_tanggal', name: 'stok_tanggal' },
            { data: 'stok_jumlah', name: 'stok_jumlah' },
            { data: 'user.nama', name: 'user.nama' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
        ],
        error: function(xhr) {
            console.log(xhr.responseText); // Debug respons error
            alert('Terjadi kesalahan saat memuat data!');
        }
    });

    // Fungsi hapus data
    window.hapusData = function (id) {
        Swal.fire({
            title: 'Yakin?',
            text: 'Data stok akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("stok") }}/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', response.message, 'success');
                        table.ajax.reload(); // Reload tabel DataTables
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    };
});
</script>

@endpush
