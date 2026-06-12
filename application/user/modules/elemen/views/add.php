<?php
$dimensi= 
	['1'=> ' <span class="badge badge-pill badge-success">Beriman, bertakwa kepada Tuhan Yang Maha Esa, dan berakhlak mulia</span>',
	 '2'=> '<span class="badge badge-pill badge-primary">Mandiri</span>',
	 '3'=> '<span class="badge badge-pill badge-warning">Bergotong-royong</span>',
	 '4'=> '<span class="badge badge-pill badge-secondary">Berbhinekaan Global</span>',
	 '5'=> '<span class="badge badge-pill badge-info">Bernalar Kritis</span>',
	 '6'=> '<span class="badge badge-pill badge-dark">Kreatif</span>'];
 ?>
<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form Menambahkan Master Elemen
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/show_add" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-sm-5 p-2 border bg-warning">
				<label><h5>Penerapan Elemen </h5></label><span></span> <br>

				<span>
					Peraturan Kemendikbud Wajib Menerapkan 3 Elemen Dasar <br><br>
					1) Nilai Agama dan Budi Pekerti<br>
					2) Jati Diri<br>
					3) Dasar-dasar Literasi, Matematika, Sains, Teknologi, Rekayasa, dan Seni<br>
				</span>
			</div>
			<div class="col-sm-7 ">
				<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/action_add" autocomplete="off">
					<div class="row">
						<span class="bg-success p-2">
							Tambahan Elemen. Jika terdapat elemen tambahan yang akan diterapkan dalam sekolah
						</span>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">Elemen : <span class="required">*</span></label>
								<input type="text" required name="elemen" class="form-control" placeholder="Elemen">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">Deskripsi : <span class="required">*</span></label>
								<textarea class="form-control" name="deskripsi" required></textarea>
							</div>
						</div>
						
						<div class="col-md-12 text-center">
							<a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Kembali</a>
							<button type="submit" class="btn btn-brand btn-elevate btn-square">Tambahkan</button>
						</div>
					</div>
				</form>
			</div>
			
			<div class="col-sm-12  mt-5 row">
				<label><h4>Elemen Yang Diterapkan</h4></label>
				<hr>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
						<thead>
							<tr>
								<th>No</th>
								<th>Elemen</th>
								<th>Deskripsi</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							 foreach ( $elemen_data as $key) :  ?>
							<tr>
								<td><?= $i; ?></td>
								<td><?= $key['elemen'] ?></td>
								<td>
									<textarea readonly class="form-control"><?= $key['deskripsi'] ?></textarea>
								</td>
								<td>
									<a href="<?php echo $url; ?>/delete_elemen/<?= $key['rowid'] ?>" class="ajaxify" aria-haspopup="true" >
										<button class="btn btn-sm btn-danger">hapus</button>
									</a>
								</td>
							</tr>
							<?php
								$i++;
							 endforeach; ;?>
						</tbody>
					</table>
				</div>
				<a href="<?php echo $url; ?>/simpan_elemen/" class="ajaxify" aria-haspopup="true" >
					<button class="btn btn-primary">Terapkan & Simpan</button>
				</a>
			</div>
			
		</div>
		
	</div>
	<a href="<?php echo $url; ?>/show_add" class="ajaxify reload"></a>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {
				password: "required",
				confirm : {
					equalTo: "#password"
				}
			},
			message = {};
		FormValidation.handleValidation(form, rule, message);
		
		$('.select2').select2();
			$('.select2-desa').select2({
			width: '100%',
			placeholder: 'Pilih Desa',
			allowClear: true,
			ajax: {
				url: base_url + '/fetch/get_desa',
				dataType: 'json',
				type: "POST",
				delay: 500,
				data: function(param) {
					return {
						q: param.term
					};
				},
				processResults: function(data, page) {
					return {
						results: data.item
					};
				},
			}
		});
	});
</script>