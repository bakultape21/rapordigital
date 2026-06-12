<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
			<i class="flaticon2-plus-1"></i> Form Kondisi Jasmani
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="col-sm-12 border " style="background-color: #90f5ac5c !important;">
			<label><h5>Deskripsi Kelas </h5></label><span> </span> <br>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Kelas : <span class="required">*</span></label>
						<input type="text" class="form-control" value="<?= $guru_sekolah->nama_kelas ?>" readonly>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Tahun Ajaran: <span class="required">*</span></label>
						<input type="text" readonly class="form-control" value ="<?= $guru_sekolah->tahun ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Semester: <span class="required">*</span></label><br>
						<input type="text" class="form-control" readonly value="<?=  ($guru_sekolah->semester==1) ? 'Ganjil' : 'Genap' ; ?>">
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-sm-12 row">
			<label><h4>Siswa Dalam Kelas </h4></label>
			<hr>
			
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
					<thead>
						<tr>
							<th>No</th>
							<th>Nomor Induk</th>
							<th>Nama Lengkap Siswa</th>
							<th>Alamat</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						foreach ($siswa_data as $key) :  ?>
						<tr>
							<td><?= $i; ?></td>
							<td><?= $key->no_induk ?></td>
							<td><?= $key->nama_lengkap ?></td>
							<td><?= $key->alamat; $i++; ?></td>
							<td>
								<?php if ($key->kondisi_jasmani_id== null) { ?>
								<a href="<?php echo $url; ?>/kondisi_jasmani/show_add/<?= ($key->siswa_kelas_id) ?>" class="ajaxify" aria-haspopup="true" >
									<button class="btn btn-sm btn-success">Input Kondisi Jasmani</button>
								</a>
							<?php }else{ ?>
								<a href="<?php echo $url; ?>/kondisi_jasmani/show_edit/<?= ($key->kondisi_jasmani_id) ?>" class="ajaxify" aria-haspopup="true" >
									<button class="btn btn-sm btn-warning">Edit Kondisi Jasmani</button>
								</a>
							<?php } ?>
							</td>
						</tr>
						<?php endforeach; ;?>
					</tbody>
					
				</table>
			</div>
			
			
		</div>
	</div>
	
</div>