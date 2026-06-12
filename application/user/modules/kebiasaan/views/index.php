<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
     .chart-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
        }
        .main-title {
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1.5rem;
        }
        .main-title {
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1.5rem;
        }
        .list-group-item {
            font-size: 1.1rem;
            font-weight: 500;
            border-left: 0;
            border-right: 0;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        /* Style for the first and last items for rounded corners */
        .list-group-item:first-child {
            border-top-left-radius: .5rem;
            border-top-right-radius: .5rem;
            border-top-width: 1px;
        }
        .list-group-item:last-child {
            border-bottom-left-radius: .5rem;
            border-bottom-right-radius: .5rem;
            border-bottom-width: 1px;
        }
</style>
<div class="row">

    <div class="kt-portlet col-sm-4">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <i class="fa fa-table"></i> 7 Kebiasaan Anak
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">				
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
             <h2 class="main-title text-center">7 Kebiasaan Hebat</h2>
             <?php if ($kebiasaan == null) { ?>
                <button type="button" 
                onclick="tarikKebiasaan('<?= $id ?>')" 
                class="btn btn-primary">Tarik Kebiasaan</button>
             <?php }else{ ?>
                <?php foreach ($kebiasaan as $item) { ?>
                    <div class="list-group-item"><img width="30" style="padding: 3px" src="<?= base_url() .'../'. $item->icon; ?>" alt="<?= $item->pertanyaan; ?>"><?= $item->pertanyaan; ?></div>
                <?php } ?>
             <?php } ?>
        </div>
    </div>
    <div class="kt-portlet col-sm-8">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <i class="fa fa-table"></i> Detail Pertanyaan 7 Kebiasaan Anak
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">				
                </div>
            </div>
        </div>
        <div class="kt-portlet__body" style="height: 600px; overflow-y: scroll;">
            <?php foreach ($kebiasaan as $key => $value) { ?>
                <li class="list-group-item">
                    <strong><img width="30" style="padding: 3px" src="<?= base_url() .'../'. $value->icon; ?>" alt="<?= $value->pertanyaan; ?>"><?php echo $value->pertanyaan; ?></strong>
                    <ul>
                        <?php foreach ($deteil_pertanyaan as $item) { 
                            if ($item->kebiasaan_id != $value->kebiasaan_id) continue; ?>
                            <li><?php echo $item->option; ?></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        </div>
    </div>
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    <i class="fa fa-table"></i> Table <?php echo $title; ?> Anak Isian Orangtua
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">				
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                    <thead>
                        <tr class="header">
                            <th width="30px">No.</th>
                            <th>Nama Siswa</th>
                            <th>Validasi Orangtua</th>
                            <th>Tanggal Pengisian</th>
                            <th>Nilai</th>
                            <th>Actions</th>
                        </tr>
                        <tr class="filter">
                            <td></td>
                            <td>
                                <input type="text" name="nama_siswa" class="form-control form-control-sm form-filter" placeholder="Nama Siswa">
                            </td><td>
                            <td></td>
                            <td></td>
                            <td class="text-center">
                                <button class="btn btn-brand kt-btn btn-sm kt-btn--icon filter-submit"> <span> <i class="la la-search"></i> <span>Search</span> </span> </button>
                                <button class="btn btn-secondary kt-btn btn-sm kt-btn--icon filter-cancel"> <span> <i class="la la-close"></i> <span>Reset</span> </span> </button>
                            </td>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Kebiasaan Anak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
<script type="text/javascript">

    function tarikKebiasaan(id) {
        if (confirm('Apakah Anda yakin ingin menarik kebiasaan ini?')) {
            $.ajax({
                url: '<?php echo base_url() ?>kebiasaan/tarik/' + id,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                if (response.status == 'success') {
                    location.reload();
                } else {
                    alert('Gagal menarik kebiasaan: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }
}
</script>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var url 	= '<?php echo $url ?>/select/<?= $id ?>';
			header 	= [
						{ "sClass": "text-center" },
						null,
						null,
						{ "sClass": "text-center" },
						{ "sClass": "text-center" },
						null,
					],
			order 	= [
						[1, "asc"]
					],
			sort 	= [0, 2, -1];

		initDT.handleRecords(url, header, order, sort);

	});

    function detailKebiasaan(id) {
        $.ajax({
            url: '<?php echo base_url() ?>kebiasaan/detail/' + id,
            type: 'GET',
            dataType: 'html',
            success: function(response) {
                // Menampilkan data dalam modal
                $('#modalDetail .modal-body').html(response);
                $('#modalDetail').modal('show');
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    }

// --- KODE BARU UNTUK MENANGANI SUBMIT FORM VALIDASI ---
$(document).on('submit', '#formValidasiGuru', function(e) {
    // Mencegah form submit default (reload halaman)
    e.preventDefault(); 
    
    var formData = $(this).serialize(); // Ambil semua data dari form
    var submitButton = $(this).find('button[type="submit"]');

    $.ajax({
        url: '<?php echo base_url() ?>kebiasaan/simpan_validasi_guru',
        type: 'POST',
        data: formData,
        dataType: 'json',
        beforeSend: function() {
            // Menonaktifkan tombol saat proses kirim
            submitButton.prop('disabled', true);
            submitButton.html('Menyimpan...');
        },
        success: function(response) {
            if (response.status == 'success') {
                alert(response.message); // Atau gunakan SweetAlert untuk notifikasi lebih baik
                $('#modalDetail').modal('hide');
                // Optional: Muat ulang data di tabel utama jika ada
                // location.reload(); atau panggil fungsi untuk refresh tabel
            } else {
                alert('Gagal: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Terjadi kesalahan AJAX: ' + error);
        },
        complete: function() {
            // Mengaktifkan kembali tombol setelah selesai
            submitButton.prop('disabled', false);
            submitButton.html('Simpan Validasi');
        }
    });
});
</script>