<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="fa fa-table"></i> Table <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<?php if (login_data('user_role')!= 3) { ?>
					<a href="<?php echo $url.'/show_add' ?>" data-permission="w" class="ajaxify btn btn-brand btnAction" aria-haspopup="true">
						<i class="fa fa-plus"></i> Tambahkan Kelas
					</a>
				<?php } ?>
				
				
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
				<thead>
					<tr class="header">
						<th width="30px">No.</th>
						<th>Kelas</th>

						<th>Guru Kelas</th>
						<th>Tahun</th>
						<th>Semester</th>
						<th width="100px">Status</th>
						<th >Actions</th>
					</tr>
					<tr class="filter">
						<td></td>
						<td>
							<input type="text" name="nama_kelas" class="form-control form-control-sm form-filter" placeholder="Kelas">
						</td><td>
						<td></td>
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

<script type="text/javascript">
	jQuery(document).ready(function() {
		var url 	= '<?php echo $url ?>/select';
			header 	= [
						{ "sClass": "text-center" },
						null,
						null,
						{ "sClass": "text-center" },
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

	function sendData(id) {
    Swal.fire({
        title: "Apakah Anda yakin Menutup Kelas ini?",
        text: " Jika sudah di tutup maka kelas tidak akan bisa di input, hanya bisa cetak!",
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then((result) => {
        if (result.value== true) {

    	// console.log("Swal result:", result.value);
            $.ajax({
                url: "<?= base_url() ?>/kelas/change_status", // Ganti dengan UR
                type: "POST",
                data: { id: id }, // Kirim data jika diperlukan
                success: function (response) {
                    Swal.fire("Sukses!", "Data berhasil dikirim.", "success");
                    location.reload();
                },
                error: function () {
                    Swal.fire("Gagal!", "Terjadi kesalahan saat mengirim data.", "error");
                }
            });
        }
    });
}
</script>