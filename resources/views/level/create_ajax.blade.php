<form action="{{ url('/level/ajax') }}" method="POST" id="form-tambah-level"> 
    @csrf 
    <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h5 class="modal-title">Tambah Level Pengguna</h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div> 
            <div class="modal-body"> 
                <div class="form-group"> 
                    <label><strong>Kode Level</strong></label> 
                    <input type="text" name="level_kode" id="level_kode" class="form-control" required> 
                    <small id="error-level_kode" class="error-text form-text text-danger"></small> 
                </div> 
                <div class="form-group"> 
                    <label><strong>Nama Level</strong></label> 
                    <input type="text" name="level_nama" id="level_nama" class="form-control" required> 
                    <small id="error-level_nama" class="error-text form-text text-danger"></small> 
                </div> 
            </div> 
            <div class="modal-footer"> 
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Kembali</button> 
                <button type="submit" class="btn btn-primary">Simpan</button> 
            </div> 
        </div> 
    </div> 
</form> 
<script> 
$(document).ready(function() { 
    $("#form-tambah-level").validate({ 
        rules: { 
            level_kode: {
                required: true,
                minlength: 2,
                maxlength: 10
            },
            level_nama: {
                required: true, 
                minlength: 3, 
                maxlength: 50 
            }
        }, 
        submitHandler: function(form) { 
            $.ajax({ 
                url: form.action, 
                type: form.method, 
                data: $(form).serialize(), 
                success: function(response) { 
                    if(response.status){ 
                        $('#myModal').modal('hide'); 
                        Swal.fire({ 
                            icon: 'success', 
                            title: 'Berhasil', 
                            text: response.message 
                        }); 
                        dataLevel.ajax.reload(); 
                    } else { 
                        $('.error-text').text(''); 
                        $.each(response.msgField, function(prefix, val) { 
                            $('#error-' + prefix).text(val[0]); 
                        }); 
                        Swal.fire({ 
                            icon: 'error', 
                            title: 'Terjadi Kesalahan', 
                            text: response.message 
                        }); 
                    } 
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan pada server.'
                    });
                }
            }); 
            return false; 
        }, 
        errorElement: 'span', 
        errorPlacement: function (error, element) { 
            error.addClass('invalid-feedback'); 
            element.closest('.form-group').append(error); 
        }, 
        highlight: function (element) { 
            $(element).addClass('is-invalid'); 
        }, 
        unhighlight: function (element) { 
            $(element).removeClass('is-invalid'); 
        } 
    }); 
});
</script>
