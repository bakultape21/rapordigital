<?php
$semester=
    ['2'=> 'Genap', '1'=> 'Ganjil'];
 ?>

<!-- Style kustom untuk daftar rekomendasi -->
<style>
    #suggestionsContainer .list-group-item {
        cursor: pointer;
        border-radius: 0; /* Menghilangkan sudut melengkung agar terlihat rapi */
    }
    #suggestionsContainer .list-group-item:hover {
        background-color: #f8f9fa; /* Warna hover abu-abu lembut */
    }
    #suggestionsContainer .list-group-item b {
        font-weight: 600; /* Dibuat tebal */
        color: #5867dd; /* Warna utama dari template Metronic */
    }
</style>


<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                <i class="fa fa-table"></i> Input TP/TK dan Nilai Belajar
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                
                <a href="<?= site_url() ?>/kelas" class="ajaxify btn btn-brand" aria-haspopup="true">
                    <i class="fa fa-redo"></i> Kembali
                </a>
                <a href="<?= site_url() ?>/nilai/list/<?= ($kelas_id) ?>" class="ajaxify btn btn-warning" aria-haspopup="true">
                     <i class="fa fa-table"></i> Daftar Input Harian
                </a>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="col-sm-6 badge badge-primary">
                <h3><label><?= $kelas->nama_kelas ?></label><br>
                    Semester <?= $semester[$kelas->semester] ?> Tahun <?= $kelas->tahun; ?>
                </h3>
            </div>
            <div class="col-sm-6">
            </div> 
            
            <div class="col-md-12">
                <hr>
                <div class="col-md-12">
                    <h3><label>Input Nilai Belajar TP Siswa</label></h3>
                </div>
                <form class="kt-form" id="form-action" data-reload='1' data-multipart='1' action="<?php echo $url; ?>/action_add" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group row">

                                <label class="form-control-label col-sm-3">Elemen Belajar Siswa : <span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <select class="select2-elemen form-control" onchange="elemen(this)" id="elemen_data_id" name="elemen_data_id" required>
                                        <option value="">Pilih Elemen</option>
                                        <?php foreach ($elemen as $key => $value) {?>
                                            <option value="<?= $value->elemen_data_id ?>"><?= $value->elemen_data ?></option>
                                        <?php } ?>
                                    </select>   
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12">

                            <div class="form-group row">

                                <label class="form-control-label col-sm-3">CP Belajar Siswa : <span class="required">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="select2-cp form-control " name="cp_id" required>
                                        </select>   
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="form-control-label col-sm-3">Kegiatan Belajar/ TP/ TK : <span class="required">*</span></label>
                                <div class="col-sm-9" style="position: relative;" id="kegiatan-wrapper">
                                    <input type="text" class="form-control" name="kegiatan_belajar" id="kegiatan_belajar_input" required autocomplete="off">
                                    <div id="suggestionsContainer" class="list-group position-absolute w-100" style="z-index: 1050; display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="form-control-label col-sm-3">Tanggal : <span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="kegiatan_tanggal" value="<?= date('Y-m-d') ?>" class="form-control datepicker" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>Nilai Siswa</h4>
                        <hr>
                        
                        <?php foreach ($siswa_data as $key => $value) : ?>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="form-control-label col-sm-3"><?= $value->nama_lengkap ?> : <span class="required">*</span></label>
                                <div class="">
                                    
                                    <input type="radio" value="0" name="kegiatan_nilai[<?= $value->siswa_kelas_id ?>]" checked id="TAN<?= $value->siswa_kelas_id ?>"> 
                                        <label class="badge badge-secondary" for="TAN<?= $value->siswa_kelas_id ?>">Tidak Ada Nilai </label> <br>
                                    <input type="radio" value="1" name="kegiatan_nilai[<?= $value->siswa_kelas_id ?>]" id="TM<?= $value->siswa_kelas_id ?>"> 
                                        <label  class="badge badge-warning" for="TM<?= $value->siswa_kelas_id ?>">Tidak Muncul </label> <br>
                                    <input type="radio" value="2" name="kegiatan_nilai[<?= $value->siswa_kelas_id ?>]" id="M<?= $value->siswa_kelas_id ?>"> 
                                        <label  class="badge badge-success" for="M<?= $value->siswa_kelas_id ?>">Muncul </label> 

                                </div>
                                <input type="hidden" name="siswa_kelas_id[]" value="<?= $value->siswa_kelas_id ?>" required>

                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-brand btn-elevate btn-square">Simpan</button>
                        </div>
                </form>

            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    var form = '#form-action',
        rule = {},
        message = {};

    FormValidation.handleValidation(form, rule, message);

    $('.select2-elemen').select2({
        width: '100%',
        placeholder: 'Pilih Elemen',
        allowClear: true
    });

    // --- SCRIPT UNTUK REKOMENDASI PENCARIAN (DENGAN DEBOUNCING) ---

    const kegiatanInput = $('#kegiatan_belajar_input');
    const suggestionsContainer = $('#suggestionsContainer');
    let debounceTimer; // Variabel untuk menyimpan timer

    // Fungsi untuk menampilkan rekomendasi (tidak berubah)
    function displayKegiatanSuggestions(suggestions, query) {
        suggestionsContainer.empty().hide();
        if (!suggestions || suggestions.length === 0) return;

        suggestions.forEach(suggestion => {
            const regex = new RegExp(`(${query})`, 'gi');
            const highlightedText = suggestion.replace(regex, '<b>$1</b>');
            const item = $('<a href="#" class="list-group-item list-group-item-action"></a>');
            item.html(highlightedText);
            item.on('click', function(e) {
                e.preventDefault();
                kegiatanInput.val(suggestion);
                suggestionsContainer.empty().hide();
            });
            suggestionsContainer.append(item);
        });
        suggestionsContainer.show();
    }

    // Event listener saat pengguna mengetik
    kegiatanInput.on('input', function() {
        const query = $(this).val();

        // 1. Hapus timer yang sedang berjalan setiap kali ada input baru
        clearTimeout(debounceTimer);

        if (query.length < 2) {
            suggestionsContainer.empty().hide();
            return;
        }

        // 2. Buat timer baru. Kode di dalamnya hanya akan berjalan jika tidak ada ketikan baru selama 350 milidetik
        debounceTimer = setTimeout(() => {
            // Panggil AJAX untuk mendapatkan data rekomendasi dari server
            $.ajax({
                url: '<?= site_url() ?>/fetch/get_kegiatan_rekomendasi',
                type: 'POST',
                dataType: 'json',
                data: { query: query },
                beforeSend: function() {
                    // Opsional: tampilkan loading indicator
                    suggestionsContainer.html('<a href="#" class="list-group-item">Mencari...</a>').show();
                },
                success: function(res) {
                    if (res && res.item) {
                        displayKegiatanSuggestions(res.item, query);
                    } else {
                        suggestionsContainer.empty().hide();
                    }
                },
                error: function(err) {
                    console.error("Gagal mengambil data rekomendasi:", err);
                    suggestionsContainer.html('<a href="#" class="list-group-item text-danger">Gagal memuat data.</a>').show();
                }
            });
        }, 350); // Jeda waktu dalam milidetik
    });

    // Sembunyikan rekomendasi jika klik di luar area input
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#kegiatan-wrapper').length) {
            suggestionsContainer.empty().hide();
        }
    });

    // --- AKHIR SCRIPT REKOMENDASI ---
});

function elemen(cek) {
    var elemen_data_id = $('#elemen_data_id').val();
    $('.select2-cp').empty();
    $.ajax({
        url: '<?= site_url() ?>/fetch/get_cp_elemen/<?= $kelas_id ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            elemen_data_id: elemen_data_id
        },
        success: function(res) {
            if (res.item) {
                for (var i = 0; i < res.item.length; i++) {
                    var newOption = new Option(res.item[i].text, res.item[i].id, false, false);
                    $('.select2-cp').append(newOption).trigger('change');
                }
            }
        }
    });

    $('.select2-cp').select2({
        width: '100%',
        placeholder: 'Pilih CP Belajar',
        allowClear: true
    });
}
</script>
<script type="text/javascript">
$(function() {
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        orientation: 'bottom auto',
        autoclose: true
    });
});
</script>

