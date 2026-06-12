
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

		<?php if (login_data('user_id')==1) { ?>
		<div class="kt-portlet__content row">
			<div class="col-md-4 bg-success">
				<h3>Kode Aktivasi Register</h3>
				<form class="kt-form" id="form-action" data-multipart='1' action="<?php echo $url; ?>/update" autocomplete="off">
					<div class="form-group">
						<label>Kode Aktivasi</label>
						<input type="text" name="code" class="form-control" value="<?= $code_register->code ?>">
					</div>
					<div class="form-group">
						<label>Berlaku Sampai</label>
						<input type="datetime-local" name="sampai" class="form-control datetime-local" value="<?= $code_register->sampai ?>">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-sm">Update</button>
					</div>
				</form>
			</div>
		</div>
		<?php } ?>
		<div class="row">
	<div class="col-md-4">
		<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;">
    <!--begin::Header-->
		    <div class="card-header pt-5" style="background-color: unset;">
		        <!--begin::Title-->
		        <div class="card-title d-flex flex-column">   
		            <!--begin::Amount-->
		            <h2 class="text-white">40</h2>
		            <!--end::Amount-->

		            <!--begin::Subtitle-->
		            <span class="text-white fw-semibold ">Schools</span>             
		            <!--end::Subtitle--> 
		        </div>
		        <!--end::Title-->         
		    </div>
		    <!--end::Header-->

		    <!--begin::Card body-->
		    <div class="card-body d-flex align-items-end pt-0">
		        <!--begin::Progress-->
		        <div class="d-flex align-items-center flex-column mt-3 w-100">
		            <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
		                <h4>43 </h4>
		                <span>Teachers</span>
		            </div>

		            <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
		                <div class="bg-white rounded h-8px" role="progressbar" style="width: 72%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
		            </div>
		        </div>
		        <!--end::Progress-->
		    </div>
		    <!--end::Card body-->
		</div>
	</div>
</div>
	</div>

</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var form 	= '#form-action',
			rule 	= {
				
			},
			message = {};
		FormValidation.handleValidation(form, rule, message);
		
	});
</script>
  <script type="text/javascript">
         $(function () {
             $('#datetime').datetimepicker();
         });
      </script>
<body>
