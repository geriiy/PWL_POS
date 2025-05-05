@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('penjualan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Transaksi</a>
        </div>
        <div class="card-body">
            <table id="datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penjualan</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(function () {
    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('penjualan.list') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'penjualan_kode' },
            { data: 'pembeli' },
            { data: 'penjualan_tanggal' },
            { data: 'aksi', orderable: false, searchable: false }
        ]
    });
});


function hapusData(id) {
    Swal.fire({
        title: 'Yakin?',
        text: "Data akan dihapus permanent!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/penjualan/' + id,
                type: 'DELETE',
                success: function(result) {
                    $('#datatable').DataTable().ajax.reload();
                    Swal.fire('Deleted!', 'Data telah dihapus.', 'success')
                }
            });
        }
    })
}
</script>
@endpush
