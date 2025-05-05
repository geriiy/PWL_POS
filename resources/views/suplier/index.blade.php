@extends('layouts.template')

@section('content')
  <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
          <a class="btn btn-sm btn-primary mt-1" href="{{ url('suplier/create') }}">Tambah</a>
          <button onclick="modalAction('{{ url('suplier/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button> 
        </div>
      </div>
      <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('suplier.export') }}" class="btn btn-success">
        <i class="fas fa-file-excel"></i> Export Excel
    </a>

    <form action="{{ route('suplier.import') }}" method="POST" enctype="multipart/form-data" class="form-inline d-flex gap-2">
        @csrf
        <input type="file" name="file" class="form-control" required accept=".xlsx,.xls,.csv">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-file-upload"></i> Import Excel
        </button>
    </form>
</div>

        <table class="table table-bordered table-striped table-hover table-sm" id="table_suplier">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Suplier</th>
            <th>Alamat</th>
            <th>Aksi</th>
          </tr>
        </thead>

        </table>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection

@push('css')
@endpush

@push('js')
  <script>
    function modalAction(url = ''){ 
      $('#myModal').load(url,function(){ 
          $('#myModal').modal('show'); 
      }); 
    } 
 
    var dataSuplier;
    $(document).ready(function() {
      dataSuplier = $('#table_suplier').DataTable({
          serverSide: true,
          ajax: {
              "url": "{{ url('suplier/list') }}",
              "dataType": "json",
              "type": "POST"
          },
          columns: [
            {
              data: "DT_RowIndex",
              className: "text-center",
              orderable: false,
              searchable: false
            },{
              data: "supplier_nama", // sesuai dengan DB
              className: "",
              orderable: true,
              searchable: true
            },{
              data: "supplier_alamat", // sesuai dengan DB
              className: "",
              orderable: true,
              searchable: true
            },{
              data: "aksi",
              className: "",
              orderable: false,
              searchable: false
            }
          ]

      });
    });
  </script>
@endpush
