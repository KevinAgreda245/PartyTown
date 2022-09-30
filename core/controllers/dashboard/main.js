$(document).ready(function () {
	fillCards();
	getAmount();
	getAmountSalesProdType();
	getCantTypeProd();  
	getMonthSales();
	getCantTypeEvent();  
	getMonthSales2();
});

//Constante para establecer la ruta y parámetros de comunicación con la API
const api = "../../core/api/invoices.php?site=dashboard&action=";
const apiPartyType = "../../core/api/partyType.php?site=dashboard&action=";
const apiProducts = "../../core/api/product.php?site=dashboard&action=";

//Función para llenar las cartas con la información
function fillCards(){
	$.ajax({
		url: apiProducts + 'fillCards',
		type: 'post',
		data: null,
		datatype: 'json'
  })
  .done(function(response){
	  if(isJSONString(response)){
		const result = JSON.parse(response);
		if(result.status){
			$('#typeProduct').text(result.dataset.Tipo + '($' +result.dataset.Monto+')');
			$('#typeEvent').text(result.dataset2.Tipo + '($' +result.dataset2.TotalTipoEvento+')');
			$('#mostProduct').text(result.dataset3.nombreProducto);
			$('#winnings').text('$'+result.dataset4.Ganancia);
			let cont = '',
				cont2 = ''
				i = 1,
				j = 1;

			result.dataset5.forEach(row=> {
				cont += `
					<h5 class="white-text">${i}° - ${row.nombreProducto}:</h5>
					<h5 class="white-text center">${row.Venta} unidades</h5>
				`
				i++;
			});
			$('#mostProducts').html(cont);
			result.dataset6.forEach(row=> {
				cont2 += `
					<h5 class="white-text">${j}° - ${row.nombreProducto}:</h5>
					<h5 class="white-text center">${row.Venta} unidades</h5>
				`
				j++;
			});
			$('#lessProducts').html(cont2);
		}
	  }
  })
}

//Función para llenar el gráfico de Volumen de ventas por Tipo de Producto por el mes actual
function getAmount() {
  	$.ajax({
      	url: api + 'getAmount',
      	type: 'post',
      	data: null,
      	datatype: 'json'
    })
    .done(function (response) {
      	//Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
      	if (isJSONString(response)) {
        	const result = JSON.parse(response);
        	//Se comprueba que no hay ventas en el mes se le muestra el mensaje de no hay ventas
        	if (result.status) {
          		let data = [],
          		monto = [];
          		result.dataset.forEach(function (row) {
          			data.push(row.Tipo);
          			monto.push(parseFloat(row.Monto).toFixed(2));
				});
				let arrayMount = ['Enero', 'Febrero','Marzo', 'Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']

				let day = new Date(); 
				barGraph("ventasMes",data,monto,"Ventas ($)","Volumen de ventas por Tipo de Producto en el mes de "+ arrayMount[day.getMonth()] +" "+ day.getFullYear())  
        	} else {
				$('#errorventasMes').removeClass('hide');
				$('#ventasMes').addClass('hide');
				$('#errorventasMes').text(result.exception)
			}
      	} else {
        	console.log(response);
      	}
    })
    .fail(function (jqXHR) {
      //Se muestran en consola los posibles errores de la solicitud AJAX
      console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
    });
}

//Función para llenar el gráfico de Volumen de ventas por Tipo de Evento por el mes actual
function getAmountSalesProdType() {
  $.ajax({
      url: apiPartyType + "getSalesPerType",
      type: "post",
      data: null,
      datatype: "json"
    })
    .done(response => {
      if (isJSONString(response)) {
		const result = JSON.parse(response);
		//Se comprueba que no hay ventas en el mes se le muestra el mensaje de no hay ventas
        if (result.status) {
			let data = [],
			monto = [];
			result.dataset.forEach(function (row) {
				data.push(row.Tipo);
				monto.push(parseFloat(row.TotalTipoEvento).toFixed(2));
		  	});
		  	let arrayMount = ['Enero', 'Febrero','Marzo', 'Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
		  	let day = new Date(); 
		  	barGraph("sales-chart",data,monto,"Ventas ($)","Volumen de ventas por Tipo de Evento en el mes de "+ arrayMount[day.getMonth()] +" "+ day.getFullYear())  
        } else {
			$('#errorsales-chart').removeClass('hide');
			$('#sales-chart').addClass('hide');
			$('#errorsales-chart').text(result.exception)
		}
      } else {
        console.log(response);
      }
    })
    .fail(function (jqXHR) {
      //Se muestran en consola los posibles errores de la solicitud AJAX
      console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
    });
}

//Función para llenar el gráfico de Cantidad de Producto por Tipo de Producto
function getCantTypeProd() {
	$.ajax({
		url: api + 'getCantTypeProd',
		type: 'post',
		data: null,
		datatype: 'json'
  })
  .done(function (response) {
		//Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
		if (isJSONString(response)) {
		  const result = JSON.parse(response);
		  //Se comprueba que no hay usuarios registrados para redireccionar al registro del primer usuario
		  if (result.status) {
				let data = [],
				monto = [];
				result.dataset.forEach(function (row) {
					data.push(row.tipoProducto);
					monto.push(row.Cantidad);
			  });
			  pieGraph("cantTypeProd",data,monto,"Unidades:","Cantidad de Producto por Tipo de Producto")  
		  } else {
			$('#errorTypeProd').removeClass('hide');
			$('#cantTypeProd').addClass('hide');
			$('#errorTypeProd').text(result.exception)
		  }
		} else {
		  console.log(response);
		}
  })
  .fail(function (jqXHR) {
	//Se muestran en consola los posibles errores de la solicitud AJAX
	console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
  });
}

//Función para llenar el gráfico de Cantidad de Producto por Tipo de Evento
function getCantTypeEvent() {
	$.ajax({
		url: api + 'getCantTypeEvent',
		type: 'post',
		data: null,
		datatype: 'json'
  })
  .done(function (response) {
		//Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
		if (isJSONString(response)) {
		  const result = JSON.parse(response);
		  if (result.status) {
				let data = [],
				monto = [];
				result.dataset.forEach(function (row) {
					data.push(row.tipoEvento);
					monto.push(row.Cantidad);
			  });
			  pieGraph("cantTypeEvent",data,monto,"Unidades:","Cantidad de Producto por Tipo de Evento")  
		  	} else {
				$('#errorTypeEvent').removeClass('hide');
				$('#cantTypeEvent').addClass('hide');
				$('#errorTypeEvent').text(result.exception)
		  }
		} else {
		  console.log(response);
		}
  })
  .fail(function (jqXHR) {
	//Se muestran en consola los posibles errores de la solicitud AJAX
	console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
  });
}

//Función para llenar el gráfico de Cantidad de Facturas en los ultimos 5 meses
function getMonthSales() {
	$.ajax({
		url: api + 'getMonthSales',
		type: 'post',
		data: null,
		datatype: 'json'
  })
  .done(function (response) {
		//Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
		if (isJSONString(response)) {
		  const result = JSON.parse(response);
		  //Se comprueba que no hay usuarios registrados para redireccionar al registro del primer usuario
		  if (result.status) {
				let data = [],
				monto = [],
				arrayMount = ['Enero', 'Febrero','Marzo', 'Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
				result.dataset.forEach(function (row) {
					data.push(arrayMount[row.Mes-1]+' '+row.periodo);
					monto.push(row.Cantidad);
			  });
			  lineGraph("monthSales",data,monto,"Facturas","Cantidad de Facturas en los ultimos 5 meses")  
		  } else {
			$('#errormonthSales').removeClass('hide');
			$('#monthSales').addClass('hide');
			$('#errormonthSales').text(result.exception)
		  }
		} else {
		  console.log(response);
		}
  })
  .fail(function (jqXHR) {
	//Se muestran en consola los posibles errores de la solicitud AJAX
	console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
  });
}

//Función para llenar el gráfico de Cantidad de Facturas en los ultimos 5 meses
function getMonthSales2() {
	$.ajax({
		url: api + 'getMonthSales2',
		type: 'post',
		data: null,
		datatype: 'json'
  })
  .done(function (response) {
		//Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
		if (isJSONString(response)) {
		  const result = JSON.parse(response);
		  //Se comprueba que no hay usuarios registrados para redireccionar al registro del primer usuario
		  if (result.status) {
				let data = [],
				monto = [],
				arrayMount = ['Enero', 'Febrero','Marzo', 'Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
				result.dataset.forEach(function (row) {
					data.push(arrayMount[row.Mes-1]+' '+row.periodo);
					monto.push(row.Monto);
			  });
			  lineGraph("monthSales2",data,monto,"Montos($)","Montos de Ventas en los ultimos 5 meses")
		  } else {
			$('#errormonthSales2').removeClass('hide');
			$('#monthSales2').addClass('hide');
			$('#errormonthSales2').text(result.exception)
		  }
		  $('#preloader').addClass('hide');
		  $('#main').removeClass('hide')
		} else {
		  console.log(response);
		}
  })
  .fail(function (jqXHR) {
	//Se muestran en consola los posibles errores de la solicitud AJAX
	console.log("Error: " + jqXHR.status + " " + jqXHR.statusText);
  });
}