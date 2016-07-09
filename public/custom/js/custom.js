// apply datatable settings to a table
function setDataTableSettings(tableId) {
	var isAdmin = $('#role').val();

	if (isAdmin == 1) {
		$(tableId).DataTable({
			'columnDefs': [
				{ 'orderable': false, 'targets': -1 },
				{ 'searchable': false, 'targets': -1 }
			],
			'processing': true,
			'pageLength': 25,
			'dom' : 'Bfrtip',
			'buttons' : [
				{
					extend: 'excel',
					exportOptions: {
						columns: ':visible'
					}
				},
				'colvis'
			],
		});
	} else {
		$(tableId).DataTable({
			'columnDefs': [
				{ 'orderable': false, 'targets': -1 },
				{ 'searchable': false, 'targets': -1 }
			],
			'processing': true,
			'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, 'All']],
			'pageLength': 25
		});
	}

}