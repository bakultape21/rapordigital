var initDT = function() {
	$.fn.dataTable.Api.register('column().title()', function() {
		return $(this.header()).text().trim();
	});
	
	return {
		handleRecords: function(url, header, order, sort, ele) {
			var grid = new h_dt();
			
			grid.init({
				src 		: (ele != null ? $(ele): $("#datatable_ajax") ),
				onSuccess	: function (grid, response) {},
				onError		: function (grid) {},
				onDataLoad	: function(grid) {
								$('.tooltips').tooltip();
								Layout.rolePermission();
							},
				dataTable 	: {
								"aoColumns"		: header,
								"bStateSave"	: true,
								"lengthMenu"	: [
														[10, 20, 50, 100, 150],
														[10, 20, 50, 100, 150]
													],
								"pageLength"	: 10,
								"ajax"			: {
													"url": url,
												},
								"columnDefs"	: [
													{ "bSortable": false, "targets": sort }
												],
								"order"			: order
							},
			});

			grid.getTableWrapper().on('keyup', '.form-filter', function (e) {
				if(e.keyCode == 13){
					$('.filter-submit').trigger('click');
				}
			});

			grid.getTableWrapper().on('change', '.select-filter', function (e) {
				$('.filter-submit').trigger('click');
			});

			grid.getTable().find('thead > tr.header').addClass('bg-gray');
			grid.getTable().find('thead > tr.header > th').addClass('text-center');

			gridT = grid;
		}
	}
}();