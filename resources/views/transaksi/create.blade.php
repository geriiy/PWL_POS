@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Tambah Transaksi</h5>
        </div>
        <div class="card-body">
        <form action="{{ route('penjualan.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="pembeli">Nama Pembeli</label>
        <input type="text" name="pembeli" class="form-control" required>
    </div>
    <hr>
    <h5>Barang</h5>
    <div id="barang-list">
        <div class="row mb-2">
            <div class="col-md-6">
                <select name="barang_id[]" class="form-control barang-select" required>
                    <option value="">- Pilih Produk -</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">
                            {{ $b->barang_nama }} (Stok: {{ $b->stok }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
</form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    $('#tambah-barang').click(function() {
        let barangRow = `
            <div class="row mb-2">
                <div class="col-md-5">
                    <select name="barang_id[]" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="harga[]" class="form-control" placeholder="Harga" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-barang"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
        $('#barang-list').append(barangRow);
    });

    $(document).on('click', '.remove-barang', function() {
        $(this).closest('.row').remove();
    });
});
</script>
<script>
$(document).ready(function() {
    $(document).on('change', '.barang-select', function() {
        let selectedOption = $(this).find('option:selected');
        let harga = selectedOption.data('harga'); // Mendapatkan harga dari atribut data-harga
        $(this).closest('.row').find('input.harga').val(harga); // Mengisi input harga secara otomatis
    });
});
</script>
<script>
$(document).ready(function () {
    $(document).on('change', '.barang-select', function () {
        let selectedOption = $(this).find('option:selected');
        let maxStok = selectedOption.data('stok'); // Mendapatkan stok dari atribut data-stok
        let jumlahInput = $(this).closest('.row').find('.jumlah-input');

        jumlahInput.on('input', function () {
            if (parseInt($(this).val()) > maxStok) {
                alert('Jumlah melebihi stok barang yang tersedia');
                $(this).val(maxStok);
            }
        });
    });
});
</script>
@endpush
