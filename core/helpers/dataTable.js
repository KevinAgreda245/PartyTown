function destroyTable(id) {
	$('#' + id).dataTable().fnDestroy();
}

function clearTable(id) {
	$('#' + id).dataTable().fnClearTable();
}

function initTable(id) {
	var table = $('#' + id).DataTable({
		"oLanguage": {
			"sProcessing": "Procesando",
			"sLengthMenu": 'Mostrar <select>' +
				'<option value="10">10</option>' +
				'<option value="20">20</option>' +
				'<option value="30">30</option>' +
				'<option value="40">40</option>' +
				'<option value="50">50</option>' +
				'</select> registros',
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando del (_START_ al _END_) de un total de _TOTAL_ registro",
			"sInfoEmpty": "Mostrando del 0 al 0 de un total de 0 registro",
			"sInfoFiltered": "(Filtrando de un total de _MAX_ registro)",
			"sInfoPostFix": "",
			"sSearch": "Buscar:",
			"sUrl": "",
			"sInfoThousands": ",",
			"sLoadingRecords": "Por favor espere",
			"oPaginate": {
				"sFirst": "Primero",
				"sLast": "Último",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			},
			"aria": {
				"sortAscending": "Ordenación ascendente",
				"sortDescending": "Ordenación descendente"
			}
		},
		responsive: {
			details: {
				renderer: $.fn.dataTable.Responsive.renderer.tableAll()
			},
		},

	});
	$('select').formSelect();
}

function initTable2(id) {
	if (localStorage.getItem('language') == 'ES') {
		var table = $('#' + id).DataTable({
			"oLanguage": {
				"sProcessing": "Procesando",
				"sLengthMenu": 'Mostrar <select>' +
					'<option value="10">10</option>' +
					'<option value="20">20</option>' +
					'<option value="30">30</option>' +
					'<option value="40">40</option>' +
					'<option value="50">50</option>' +
					'</select> registros',
				"sZeroRecords": "No se encontraron resultados",
				"sEmptyTable": "Ningún dato disponible en esta tabla",
				"sInfo": "Mostrando del (_START_ al _END_) de un total de _TOTAL_ registro",
				"sInfoEmpty": "Mostrando del 0 al 0 de un total de 0 registro",
				"sInfoFiltered": "(Filtrando de un total de _MAX_ registro)",
				"sInfoPostFix": "",
				"sSearch": "Buscar:",
				"sUrl": "",
				"sInfoThousands": ",",
				"sLoadingRecords": "Por favor espere",
				"oPaginate": {
					"sFirst": "Primero",
					"sLast": "Último",
					"sNext": "Siguiente",
					"sPrevious": "Anterior"
				},
				"aria": {
					"sortAscending": "Ordenación ascendente",
					"sortDescending": "Ordenación descendente"
				}
			},
			responsive: {
				details: {
					renderer: $.fn.dataTable.Responsive.renderer.tableAll()
				},
			},

		});
		$('select').formSelect();
	} else {
		var table = $('#' + id).DataTable({
			responsive: {
				details: {
					renderer: $.fn.dataTable.Responsive.renderer.tableAll()
				},
			},

		});
		$('select').formSelect();
	}
}