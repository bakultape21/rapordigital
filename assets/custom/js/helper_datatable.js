var h_dt = function() {
	var tableOptions; // main options
	var dataTable; // datatable object
	var table; // actual table jquery object
	var tableContainer; // actual table container object
	var tableWrapper; // actual table wrapper jquery object
	var tableInitialized = false;
	var ajaxParams = {}; // set filter mode
	var the;

	return {
		init : function(options) {
			if (!$().DataTable) {
				return;
			}

			the = this;

			options = $.extend(true, {
				src					: "",
				filterApplyAction	: "filter",
				filterCancelAction 	: "filter_cancel",
				dataTable: {
					pageLength		: 10,
					language		: {
										"infoEmpty"		: "No records found to show",
										"emptyTable"	: "No data available in table",
										"zeroRecords"	: "No matching records found",
										"paginate"		: {
															"previous": "Prev",
															"next": "Next",
															"last": "Last",
															"first": "First",
															"page": "Page",
															"pageOf": "of"
														}
									},
					orderCellsTop	: true,
					columnDefs		: [{
										'orderable'	: false,
										'targets'	: [0]
									}],
					pagingType		: "simple_numbers",
					autoWidth		: false,
					processing		: true,
					serverSide		: true,
					searching		: false,
					ajax 			: {
										"url"		: "",
										"type"		: "POST",
										"timeout"	: 20000,
										"data"		: function(data) {
														$.each(ajaxParams, function(key, value) {
															data[key] = value;
														});
													},
										"dataSrc"	: function(res) {
														if (tableOptions.onSuccess) {
															tableOptions.onSuccess.call(undefined, the, res);
														}
														return res.data;
													},
										"error"		: function() {
														if (tableOptions.onError) {
															tableOptions.onError.call(undefined, the);
														}
													},
									},
					drawCallback 	: function(oSettings) {
										if (tableInitialized === false) {
											tableInitialized = true;
											table.show();
										}

										if (tableOptions.onDataLoad) {
											tableOptions.onDataLoad.call(undefined, the);
										}
									}
				}
			}, options);

			tableOptions 	= options;
			table 			= $(options.src);

			var tmp 		= $.fn.dataTableExt.oStdClasses;

			$.fn.dataTableExt.oStdClasses.sWrapper 		= $.fn.dataTableExt.oStdClasses.sWrapper + " dataTables_extended_wrapper";
			$.fn.dataTableExt.oStdClasses.sFilterInput 	= "form-control input-xs input-sm input-inline";
			$.fn.dataTableExt.oStdClasses.sLengthSelect = "form-control input-xs input-sm input-inline";

			dataTable 		= table.DataTable(options.dataTable);

			$.fn.dataTableExt.oStdClasses.sWrapper 		= tmp.sWrapper;
			$.fn.dataTableExt.oStdClasses.sFilterInput 	= tmp.sFilterInput;
			$.fn.dataTableExt.oStdClasses.sLengthSelect = tmp.sLengthSelect;

			tableWrapper = table.parents('.dataTables_wrapper');

			table.on('click', '.filter-submit', function(e) {
				e.preventDefault();
				the.submitFilter();
			});

			table.on('click', '.filter-cancel', function(e) {
				e.preventDefault();
				the.resetFilter();
			});

			table.on('click', '.filter-status', function(e) {
				e.preventDefault();

				sort = $(this).data('status');

				// if( sort == '0' ){
				// 	$(this).data('status', '99');
				// 	$(this).removeClass('blue-madison').addClass('grey-cascade');
				// 	$(this).attr('data-original-title', 'Show Deleted Only');
				// } else if(sort == '99') {
				// 	$(this).data('status', '1');
				// 	$(this).removeClass('grey-cascade').addClass('red');
				// 	$(this).attr('data-original-title', 'Show Active Only');
				// } else if(sort == '1') {
				// 	$(this).data('status', '');
				// 	$(this).removeClass('red').addClass('green');
				// 	$(this).attr('data-original-title', 'Show Active & InActive');
				// } else if(sort == '') {
				// 	$(this).data('status', '0');
				// 	$(this).removeClass('green').addClass('blue-madison');
				// 	$(this).attr('data-original-title', 'Show InActive Only');
				// }
				$(this).tooltip('fixTitle').tooltip('show');

				the.setAjaxParam('filterstatus', sort);
				the.submitFilter();
			});
		},

		submitFilter: function() {
			the.setAjaxParam("action", tableOptions.filterApplyAction);

			$('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function() {
				the.setAjaxParam($(this).attr("name"), $(this).val());
			});

			$('input.form-filter[type="checkbox"]:checked', table).each(function() {
				the.addAjaxParam($(this).attr("name"), $(this).val());
			});

			$('input.form-filter[type="radio"]:checked', table).each(function() {
				the.setAjaxParam($(this).attr("name"), $(this).val());
			});

			dataTable.ajax.reload();
		},

		resetFilter: function() {
			$('textarea.form-filter, select.form-filter, input.form-filter', table).each(function() {
				$(this).val("");
			});
			
			$('input.form-filter[type="checkbox"]', table).each(function() {
				$(this).attr("checked", false);
			});
			
			$('select.select2').val('').trigger('change');

			the.clearAjaxParams();
			the.addAjaxParam("action", tableOptions.filterCancelAction);
			dataTable.ajax.reload();
		},

		setAjaxParam: function(name, value) {
			ajaxParams[name] = value;
		},

		addAjaxParam: function(name, value) {
			if (!ajaxParams[name]) {
				ajaxParams[name] = [];
			}

			skip = false;
			for (var i = 0; i < (ajaxParams[name]).length; i++) { // check for duplicates
				if (ajaxParams[name][i] === value) {
					skip = true;
				}
			}

			if (skip === false) {
				ajaxParams[name].push(value);
			}
		},

		clearAjaxParams: function(name, value) {
			ajaxParams = {};
		},

		getDataTable: function() {
			return dataTable;
		},

		getTableWrapper: function() {
			return tableWrapper;
		},

		gettableContainer: function() {
			return tableContainer;
		},

		getTable: function() {
			return table;
		}
	}
}