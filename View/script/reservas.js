
let salaid;
let reseva;
	
$(document).ready(function(){

	listarSala();

	var btnConsulta=document.querySelector('#btnConsultar');


	btnConsulta.addEventListener('click', function(e) {
		e.preventDefault();

		var sala=document.querySelector('#sala').value;

		if (sala=='') {
			document.querySelector('#rptaConsulta').innerHTML='<p class="text-danger">Se debe seleccionar una clase</p>';
		}else{
			consultaResponsable(sala);
			consultarSala(sala);
			document.querySelector('#rptaConsulta').innerHTML='';
		}
		
	})

	const formularioReserva=document.getElementById('formReserva');

		formularioReserva.addEventListener('submit', function(event){
			event.preventDefault();

			document.querySelector("#rptaConsulta").innerHTML ='';
			document.querySelector("#rptaFechaInicial").innerHTML ='';
			document.querySelector("#rptaFechaFinal").innerHTML ='';

			var datos=new FormData(formularioReserva);

			Swal.fire({
			  title: 'Confirmar reserva',
			  text: '',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#28a745',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, Reservar!',
			  cancelButtonText: 'No, Cancelar!'
			}).then((result) => {
			 
			if (result.isConfirmed) { //SI DA CLICK EN CONFIRMAR


			fetch('../Controller/reservasController.php?option=insert',{
				method: 'POST',
				body: datos,
			})
			.then(response => response.json())
			.then(data => {
				if (data.status==false) {
					document.querySelector("#"+data.element).innerHTML =`<p class="text-danger">${data.message}</p>`;
					 			
				}else if(data.status==true){
					Swal.fire(
					  '',
					  'Reserva realizada!',
					  'success'
					);
					consultarSala(datos.get('sala')); //ATUALIZAMOS LA TABLA 
				}
			})			 
			  }else{ //SI DA CLICK EN CANCELAR
			  	Swal.fire(
			      'Cancelado!',
			      'Reserva cancelada',
			      'cancel'
			    )
			  }
			})


		});


	const formUpdate=document.getElementById('formUpdate');

		formUpdate.addEventListener('submit', function(event){
			event.preventDefault();

			var datos=new FormData(formUpdate);
			datos.append("id",reserva);
			datos.append("sala",salaid);

			Swal.fire({
			  title: 'Confirmar reserva',
			  text: '',
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#28a745',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, Reservar!',
			  cancelButtonText: 'No, Cancelar!'
			}).then((result) => {
			 
			if (result.isConfirmed) { //SI DA CLICK EN CONFIRMAR


				fetch('../Controller/reservasController.php?option=update',{
					method: 'POST',
					body: datos,
				})
				.then(response => response.json())
				.then(data => {
					console.log(data)
					if (data.status==false) {
						
						document.querySelector("#"+data.element).innerHTML =`<p class="text-danger">${data.message}</p>`;
									
					}else if(data.status==true){
						Swal.fire(
						'',
						'Reserva actualizada!',
						'success'
						);
						consultarSala(datos.get('sala')); //ATUALIZAMOS LA TABLA 
					}
				})			 
			  }else{ //SI DA CLICK EN CANCELAR
			  	Swal.fire(
			      'Cancelado!',
			      'Reserva cancelada',
			      'cancel'
			    )
			  }
			})


		});




}) //FIN DOCUMENT.READY


function consultaResponsable(sala){
	
	fetch('../Controller/reservasController.php?option=getResponsable&query='+sala)

	.then(response => response.json())
	.then(data => {
		if (data.status==false) {

			document.querySelector('#rstaResponsable').innerHTML =` 
																<p>Profesor:</p>
																 <p class="text-danger"><strong>No se encontro profesor</strong></p>`;

			

		}else if(data.status==true){
 				var datos = data;
				document.querySelector('#rstaResponsable').innerHTML =`<p>Profesor:</p>
																	   <p class="text-primary"><strong>${datos.data}</strong></p>`;
		}
	})

}

function consultarSala(sala){

		$('#card').css('display','block');

	    tabla=$('#tableReservas').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		"ajax":
		{
			url:'../Controller/reservasController.php?option=search&query='+sala,
			type:'GET',
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":10,//paginacion
		"iDisplayStart": 20,
		"order":[[1,"desc"]] //ordenar (columna, orden)
	}).DataTable();

}


function listarSala(){
	
	fetch('../Controller/reservasController.php?option=listRoom')

	.then(response => response.json())
	.then(data => {
		if (data.status==false) {

			document.querySelector('#rptaListaSala').innerHTML =` 
																<div class="alert alert-danger  alert-dismissible fade show" role="alert">
																  <strong>No se han encontrado salas para realizar reservas</strong>
																 
																</div>

			 													`;
		}else if(data.status==true){
 	
				for(item of data.data){
					document.getElementById("sala").innerHTML += "<option value='"+item.sala_id+"'>"+item.sala_nombre+"</option>"; 				
				}			
		}
	})

}


function deleteItem(item){
	Swal.fire({
		title: 'Confirmar eliminación',
		text: '',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#28a745',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!',
		cancelButtonText: 'No, Cancelar!'
	  }).then((result) => {
	   
	 	 if (result.isConfirmed) { //SI DA CLICK EN CONFIRMAR

			fetch('../Controller/reservasController.php?option=delete&query='+item)

			.then(response => response.json())
			.then(data => {

				console.log(data)
				if (data.status==false) {

					document.querySelector('#rstaResponsable').innerHTML =` 
																		<p>Profesor:</p>
																		<p class="text-danger"><strong>No se encontro profesor</strong></p>`;
				}else if(data.status==true){
					Swal.fire(
						'Eliminación realizada!',
						'',
						'success'
						)
					var sala = document.querySelector('#sala').value;
					consultarSala(sala);
				}
			})
		}else{ //SI DA CLICK EN CANCELAR
			Swal.fire(
			'Cancelado!',
			'Eliminación cancelada',
			'cancel'
			)
		}
	})
}

function fnConsulta(item){
	reserva = item;
	
	fetch('../Controller/reservasController.php?option=select&query='+item)

		.then(response => response.json())
		.then(data => {
			if (data.status==false) {
				Swal.fire(
			      'reserva no encontrada',
			      '',
			      'error'
			    )
				 $('#rstaNuevaSala').css('display','block');
			}else if(data.status==true){
				$('#ModalUpdate').modal('show');
	
				var datos = data.datos;
				for(i of datos){
					 salaid=i.sala_id;
					 document.querySelector('#salau').textContent=i.sala_nombre;
					 document.querySelector('#responsableu').textContent=i.sala_responsable;
					 document.querySelector('#fechainicialu').textContent=i.rese_fecha_hora_inicial;
					 document.querySelector('#fechafinalu').textContent=i.rese_fecha_hora_final;
					 document.querySelector('#preciou').textContent=i.rese_precio;
				}
			
			}
		})
}

