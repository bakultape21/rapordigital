
<?php
$semester=[
			'1'=> '<label class="badge badge-primary"> Ganjil</label>',
			'2'=> '<label class="badge badge-danger"> Genap</label>'
		];

		$status=[
			'0'=> '<label class="badge badge-warning"> Berjalan </label>',
			'1'=> '<label class="badge badge-success"> Selesai</label>'
		];


 ?>
<div class="row">
	<div class="col-md-8">
		<div class="kt-portlet kt-portlet--height-fluid">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
					<i class="fa fa-desktop"></i> <?php echo $title; ?>
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
						<a href="<?php echo $url ?>" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
							<i class="fa fa-redo"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="kt-portlet__body">
				<div class="kt-portlet__content row">
					<div class="col-md-12 row">

						<div class="col-md-12 p-2 border">
							<div>
								<h4>Selamat Datang, <?= $kuota->guru_nama ?></h4>
							</div>
							
						</div>
						
						<div class="col-md-6 p-2 border">
							<?php if(!empty($elemen)): ?>
							<h4><span class="badge badge-primary">Elemen Dasar yang Diterapkan</span></h4> <br>
							<?php foreach ($elemen as $key => $value) : ?>
							<?= $value->elemen_nomor.'. '.$value->elemen_data; ?><br>
							<?php endforeach; ?>
							<?php else: ?>
							<center>
							<h5>Sekolah Anda Belum Memiliki Elemen Yang Diterapkan</h5>
							<hr>
							<a href="<?= site_url() ?>/elemen/show_add" class="ajaxify " aria-haspopup="true">
								<button class="btn btn-warning">Buat Elemen</button>
							</a>
							<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#tarik_data" >Tarik Data Elemen</button>
							</center>
							<?php endif; ?>
						</div>
						<div class="col-md-6 p-2 border">
							<table class="table">
								<thead>
									<tr>
										<th>Kelas</th>
										<th>Tahun/Semester</th>
										<td>Status</td>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($kelas as $key => $value) : ?>
									<tr>
										<td>
											<a href="<?= site_url() ?>/kelas/edit">
												<?= $value->nama_kelas  ?>
											</a>
										</td>
										<td><?= $value->tahun.'/'.$semester[$value->semester] ?></td>
										<td><?= $status[$value->kelas_status] ?></td>
									</tr>
									<?php endforeach ?>
								</tbody>
							</table>
							<span class="badge badge-warning">Kuota Semester Anda <strong><?= $kuota->batas_semester ?></strong> Terpakai <strong><?= $kuota->kuota_saat_ini ?></strong></span>
							<a href="<?= base_url() ?>pembayaran">
								<button class="btn btn-success">Tambah Kuota Semester</button>
							</a>
						</div>
						<div class="col-md-6 p-2 border" >
							<!-- <canvas id="myChart" style="width:100%;max-width:600px"></canvas> -->
							
						</div>
						<div class="col-md-6 p-2 border">
							
							<!-- <canvas id="myChart1" style="width:100%;max-width:600px"></canvas> -->
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<div class=" col-md-4">
		<div class="kt-portlet  kt-portlet--height-fluid">
			<div  class="kt-portlet__head bg-warning">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
					Notifikasi Update
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
						<a href="#" class="ajaxify btn btn-icon btn-danger" aria-haspopup="true">
							<i class="fa fa-bell"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="kt-portlet__body">
				<?php foreach ($notifikasi as $key => $value) : ?>
				<strong><?= $value->judul ?></strong>
				<span class="badge badge-warning"><?= $value->waktu_input ?></span>
				<p><?= $value->isi_notifikasi; ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="tarik_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tarik Data Master Capaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="col-md-12">
	       	<span class="badge badge-warning">
	       		<strong>Tarik Data Master Elemen</strong> adalah menu untuk memasukan <br>
	       						data <strong>Elemen</strong> digunakan oleh masing-masing lembaga <br>
	       						sehingga <strong>Guru</strong> tidak harus memasukan ulang data 
	       						 Elemen. <br>
	       	</span>
	       	<br>
	       	<hr>
	       	<?php foreach ($kelompok as $key => $value): ?>
	       		<button class="btn btn-sm btn-primary" onclick="return insert_elemen('<?= $value->kelompok_id ?>')" type="button"><?= $value->nama_kelompok ?></button>
	       	<?php endforeach; ?>
	       </div>
	       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<style type="text/css">
/* Style for zoom in zoom out animation */
.zoom-in-out-box {
  /* Set margin around the element */
  margin: 24px;
  margin-top:0px !important;
  /* Set width of the element */
  width: 100%;
  /* Set height of the element */
  height: 0;
  /* Set background color of the element */

  /* Apply animation named 'zoom-in-zoom-out' with duration of 1 second, easing effect, and infinite repetition */
  animation: zoom-in-zoom-out 2s ease infinite;
}

/* Keyframes for the zoom in zoom out animation */
@keyframes zoom-in-zoom-out {
  /* At the beginning of the animation */
  0% {
    /* Scale the element to its original size */
    transform: scale(1, 1);
  }
  /* At the middle of the animation */
  50% {
    /* Scale the element to 1.5 times its original size */
    transform: scale(1.1, 1.1);
  }
  /* At the end of the animation */
  100% {
    /* Scale the element back to its original size */
    transform: scale(1, 1);
  }
}
</style>

<script type="text/javascript">
	var xValues = ["1A", "1B", "1C", "2A", "2B"];
	var yValues = [55, 49, 44, 24, 15];
	var barColors = ["red", "green","blue","orange","brown"];

	new Chart("myChart", {
	  type: "bar",
	  data: {
	    labels: xValues,
	    datasets: [{
	      backgroundColor: barColors,
	      data: yValues
	    }]
	  },
	  options: {
	    legend: {display: false},
	    title: {
	      display: true,
	      text: "Rasio Kelas"
	    }
	  }
	});

var xValue = ["1A", "1B", "1C", "2B", "2C"];
var yValue = [55, 49, 44, 24, 15];
var barColor = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("myChart1", {
  type: "pie",
  data: {
    labels: xValue,
    datasets: [{
      backgroundColor: barColor,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Rasio Daerah"
    }
  }
});

function insert_elemen(kelompok_id) {
	var cek = confirm("Anda Yakin Untuk Tarik Data Elemen ini?");
	if (cek==true) {
		
			$.ajax({
				url: '<?= site_url() ?>/dashboard/set_elemen',
				type: 'POST',
				dataType: 'json',
				data : {kelompok_id:kelompok_id},
				success: function(res){

					if (res.status==2) {
						toastr.warning(res.message);
					}else{
						toastr.success(res.message);

						location.reload();
					}
					
				}
			});
	}else{
		
	}
}
</script>
<body>
