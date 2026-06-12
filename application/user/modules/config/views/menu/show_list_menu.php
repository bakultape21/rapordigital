<div class="kt-portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				<i class="flaticon2-plus-1"></i> Form <?php echo $title; ?>
			</h3>
		</div>
		<div class="kt-portlet__head-toolbar">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a href="<?php echo $url; ?>/show_list_menu" class="ajaxify btn btn-icon btn-brand" aria-haspopup="true">
					<i class="fa fa-redo"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="kt-portlet__body">
		<menu id="nestable-menu">
			<button class="btn btn-sm btn-primary tooltips" data-action="expand-all" data-original-title="Expand All">
				Expand All
			</button>
			<button class="btn btn-sm btn-success tooltips" data-action="collapse-all" data-original-title="Collapse All">
				Collapse All
			</button>
		</menu>

		<div class="row">
			<div class="col-md-12">
				<?php v_list_menu(menu('all')); ?>
			</div>
			<div class="col-md-12">
				<hr>
				<div class="text-center">
					<a href="<?php echo $url; ?>" class="ajaxify btn btn-warning btn-elevate btn-square">Back</a>
					<button type="button" id="save_form" class="btn btn-brand btn-elevate btn-square">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		$('.dd').nestable({
			'group' : 0,
			'maxDepth' : 10
		});

		$('#nestable-menu').on('click', function(e) {
			var target = $(e.target),
				action = target.data('action');

			if (action === 'expand-all') {
				$('.dd').nestable('expandAll');
			}
			if (action === 'collapse-all') {
				$('.dd').nestable('collapseAll');
			}
		});

		$('#save_form').on('click', function(e){
			e.preventDefault();

			var data = $('.dd').nestable('serialize');

			$.post('<?php echo $url; ?>/save_list', { data : data } , function(data) {
				if(data.status == '1') {
					toastr.success(data.message);
					location.reload();
				} else {
					toastr.error(data.message);
				}
			}, 'json');
		});
	});
</script>