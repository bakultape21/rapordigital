<style type="text/css">
	body{
		font-size: 15px !important;
	}
</style>
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form Pembayaran Perpanjangan Kuota Semester
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?= base_url() ?>pembayaran/" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i> Kembali
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-sm-4 row bordered">
				<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/save_pembayaran" autocomplete="off">
					<div class="form-group">
						<label class="form-label">Nama Guru</label>
						<input type="text" value="<?= $guru->guru_nama ?>" readonly class="form-control">
						<input type="hidden" name="guru_id" value="<?= $guru->guru_id ?>">
					</div>
					<div class="form-group">
						<label class="form-label">Nominal</label>
						<input type="text" readonly value="<?= $guru->nominal_tagihan ?>" class="form-control" name="nominal_tagihan">
					</div>
					<div class="form-group">
						<label>Bukti Bayar</label>
						<input type="file" name="bukti_bayar">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Upload Bukti Bayar</button>
					</div>
				</form>
			</div>
		</div>
		
	</div>
	<a href="<?php echo $url; ?>" class="ajaxify reload"></a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {
			},
			message = {};

		FormValidation.handleValidation(form, rule, message);
		
	});

	// jQuery(document).ready(function() {
	// 	var form1 	= '#form-action-kelas',
	// 		rule1 	= {
	// 		},
	// 		message1 = {};

	// 	FormValidation.handleValidation(form1, rule1, message1);
	// });

	
	  $( function() {
    $( ".datepicker" ).datepicker({
    	format: "yyyy-mm-dd",
    	orientation: 'bottom auto',
		autoclose: true
    });
  } );

	
</script>
