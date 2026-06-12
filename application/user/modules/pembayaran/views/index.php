<style type="text/css">
	body{
		font-size: 15px !important;
	}
</style>
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Pembayaran Perpanjangan Kuota Semester
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?= base_url() ?>pembayaran/add_pembayaran" class="ajaxify btn btn-brand" aria-haspopup="true">
					<i class="fa fa-plus"></i> Upload Bukti Bayar
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
				<div class="col-sm-6 ">

					<div class="container">
				 		<h4>Nominal Perpanjangan anda adalah <span class="badge badge-primary">Rp.<?= number_format($nominal_tagihan); ?></span> </h4> 
				 		<hr>
				 		<h5>Cara Pembayaran</h5>
				 		<hr>
				 		<ul>
							<li>
								<strong>Langkah 1: Transfer</strong>
								<ul>
									<li>Transfer dengan nominal yang sesuai dengan nominal tagihan anda.</li>
									<li>Screenshoot bukti transfer anda.</li>
									<li>No. Rek BCA : 1841155063 <br>
									A/N : Muhammad Sholihuddin <br>
									No. Rek BRI : 700401013277532 <br>
									A/N : Muhammad sholihuddin</li>
								</ul>

							</li>
							<li>
								<strong>Langkah 2: Konfirmasi</strong>
								<ul>
									<li>Upload bukti transfer pada form disamping.</li>
									<li>Submit Bukti transfer.</li>
								</ul>
							</li>
							<li>
								<strong>Langkah 3: Verifikasi</strong>
								<ul>
									<li>Tunggu Verifikasi dari team kami.</li>
									<li>Jika sudah diverifikasi, kuota semester anda akan otomatis bertambah.</li>
								</ul>
							</li>
						</ul>
				 		
				  	</div>
			<!-- 	<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add" autocomplete="off"> -->
					
				<!-- </form> -->
			</div>
			<div class="col-sm-6 row">
				<div class="container">
					<div class="col-sm-12">
						<h3>History Pembayaran</h3>
					</div>
					<div class="col-sm-12">
						<table class="table table-border">
							<thead>
								<tr>
									<th>Waktu Bayar</th>
									<th>File bukti Bayar</th>
									<th>Nominal Bayar</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($list_pembayaran as $key => $value) {?>
									<tr>
										<td><?= date('d-m-Y', strtotime($value->waktu_bayar)) ?></td>
										<td><img width="50" src="<?= base_url( $value->file) ?>"></td>
										<td>Rp.<?= number_format($value->nominal) ?></td>
										<td><?php if ($value->status==0) { ?>
											<span class="badge badge-warning">proses konfirmasi</span>
										<?php }elseif($value->status==1){ ?>
											<span class="badge badge-success">Diterima</span>
										<?php }else{ ?>
											<span class="badge badge-danger">Ditolak</span>
										<?php } ?>
											
										</td>
									</tr>
								<?php } ?>
								
							</tbody>
						</table>
					</div>
				</div>
				
				

			
			</div>
			<!-- <div class="col-sm-4 row bg-success">
				<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add" autocomplete="off">
					<div class="form-group">
						<label>Bukti Bayar</label>
						<input type="file" name="bukti_bayar">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Upload Bukti Bayar</button>
					</div>
				</form>
			</div> -->
			
		
			
			
			
		</div>
		
	</div>
	<a href="<?php echo $url; ?>/" class="ajaxify reload"></a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		// var form 	= '#form-action',
		// 	rule 	= {
		// 	},
		// 	message = {};

		// FormValidation.handleValidation(form, rule, message);
		
	});

	jQuery(document).ready(function() {
		var form1 	= '#form-action-kelas',
			rule1 	= {
			},
			message1 = {};

		FormValidation.handleValidation(form1, rule1, message1);
	});

	
	  $( function() {
    $( ".datepicker" ).datepicker({
    	format: "yyyy-mm-dd",
    	orientation: 'bottom auto',
		autoclose: true
    });
  } );

	
</script>
