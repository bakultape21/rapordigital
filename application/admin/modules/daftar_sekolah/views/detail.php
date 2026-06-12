<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Detail sekolah
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/show_detail/<?php echo $id; ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div class="row">
			<div class="col-md-8 row" style="background: #dde7ff; padding-top: 20px;">
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nama Sekolah : <span class="required">*</span></label>
						<input readonly type="text" required name="sekolah_nama" class="form-control" value="<?= $record->sekolah_nama ?>" placeholder="Full Name">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">npsn : <span class="required">*</span></label>
						<input readonly type="text" required name="npsn" value="<?= $record->npsn ?>" class="form-control" placeholder="npsn">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">SK : <span class="required">*</span></label>
						<input readonly type="text"  name="sk" value="<?= $record->sk ?>" class="form-control" placeholder="SK">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Nomor Telepon : <span class="required">*</span></label>
						<input readonly type="nomor_telepon"  value="<?= $record->nomor_telepon ?>" name="nomor_telepon" class="form-control" placeholder="Nomor Telepon">
					</div>
				</div>

			
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Alamat : <span class="required">*</span></label>
						<textarea readonly class="form-control" name="alamat"><?= $record->alamat ?></textarea>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Akreditasi : <span class="required">*</span></label>
						<input readonly type="text" class="form-control" value="<?= $record->akreditasi ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="form-control-label">Kabupaten : <span class="required">*</span></label>
						<input readonly type="text" class="form-control" value="<?= $record->kabupaten ?>">
					</div>
				</div>
				
			</div>
			<div class="col-md-4 " style="padding-top: 10px;margin: 10px;">
				<div>
					<span style="font-size: 15px; font-weight: 600;">Daftar Guru</span>
					<hr>
				</div>

				<table class="table">
					<thead>
						<tr>
							<th>NIP</th>
							<th>Nama</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($guru as $key ) { ?>
						<tr>
							<td><?= $key->nip ?></td>
							<td><?= $key->guru_nama; ?></td>
							<td><button type="button" onclick="tanggal(this)" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal<?= strEncrypt($key->guru_id) ?>">
							  Laporan
							</button>
						</td>
						</tr>

						<div class="modal fade" id="exampleModal<?= strEncrypt($key->guru_id) ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Cetak Laporan</h5>
						      </div>
						      <div class="modal-body">
						        <form method="post" target="_blank" action= "<?= base_url() ?>/daftar_sekolah/action_laporan/guru/<?= strEncrypt($key->guru_id) ?>">
						        	<div class="form-group">
						        		<label>Semester</label> <br>
						        		<input type="radio" name="semester" value="1"> Ganjil <br>
						        		<input type="radio" name="semester" value="2"> Genap <br>
						        	</div>
						        	<div class="form-group">
						        		<label>Tahun Ajaran</label>
						        		<select class="form-control" required name="tahun">
						        			<option value="2021">2021</option>
						        			<option value="2022">2022</option>
						        			<option value="2023">2023</option>
						        			<option value="2024">2024</option>
						        			<option value="2025">2025</option>
						        			<option value="2026">2026</option>
						        		</select>
						        	</div>
						        	<div class="form-group">
						        		<label>Dari Tanggal</label>
						        		<input class="datepicker form-control" type="date" name="awal">
						        	</div>
						        	<div class="form-group">
						        		<label>Sampai Tanggal</label>
						        		<input class="datepicker form-control" type="date" name="akhir">
						        	</div>
						        	<div class="form-group">
						        		<label>Tanggal Cetak</label>
						        		<input class="datepicker form-control" type="date" name="tanggal_cetak">
						        	</div>
						        	<div class="form-group">
						        		<button class="btn btn-sm btn-primary" type="submit">cetak</button>
						        	</div>
						        </form>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						      </div>
						    </div>
						  </div>
						</div>

						<?php } ?>
					</tbody>
				</table>
				
			</div>

			<div class="col-md-12 text-center">
					<a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Back</a>
					
				</div>
		</div>
	</div>
</div>

<script type="text/javascript">

</script>
