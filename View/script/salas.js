	const Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 3000,
	  timerProgressBar: true,
	  didOpen: (toast) => {
	    toast.addEventListener('mouseenter', Swal.stopTimer)
	    toast.addEventListener('mouseleave', Swal.resumeTimer)
	  }
	});

	let sala;
	const formularioRegistro=document.getElementById('formSala');
	const formularioActualizacion=document.getElementById('formSalaUpdate');
	const btnBuscar=document.getElementById('btnSearch');
	const btnNuevoClase=document.getElementById('btnNuevoClase');
	
	
	formularioRegistro.addEventListener('submit', function(event){
		event.preventDefault();

		var datos=new FormData(formularioRegistro);

		fetch('../Controller/salasController.php?option=insert',{
			method: 'POST',
			body: datos,
		})
		.then(response => response.json())
		.then(data => {
			if (data.status==false) {
				document.querySelector('#rptaNuevaSala').innerHTML =`
																	<div class="alert alert-danger" role="alert">
																	<strong>${data.message} </strong>
																	</div>
																	`;
				 $('#rstaNuevaSala').css('display','block');
			}else if(data.status==true){
				$('#ModalForm').modal('hide');
				Swal.fire(
					'Nueva sala creada!',
					'',
					'success'
				  );
			    fnSearch(datos.get('nombre'));
				
			
			}
		})
	});

	formularioActualizacion.addEventListener('submit', function(event){
		event.preventDefault();
		
	 	var datos=new FormData(formularioActualizacion);
	 	datos.append("id",sala);

		fetch('../Controller/salasController.php?option=update',{
			method: 'POST',
			body: datos,
		})
		.then(response => response.json())
		.then(data => {
			  console.log(data);
			if (data.status==false) {
				document.querySelector('#rptaActualizarSala').innerHTML =`
				<div class="alert alert-danger" role="alert">
				   <strong>${data.message} </strong>
				</div>
				 `;
				$('#rptaActualizarSala').css('display','block');
			}else if(data.status==true){
				Swal.fire(
					'Clase Actualizada',
					'',
					'success'
				  );
				  $('#modalFormUpdate').modal('hide');
			}
		})
	});

	btnBuscar.addEventListener('click', function(event) {
		event.preventDefault();

		var datos=document.getElementById("nombreBusqueda").value;

		if (datos=='') {
			document.getElementById("nombreBusqueda").focus()
		}else{

			$.post( "../Controller/salasController.php?option=search",{query:datos})
		  		.done(function( data ) {
		    	if (data.status==false) {
		    		
		    		document.querySelector('#rptaConsuta').innerHTML = `<p class="text-danger">${data.message}</p>`;
		    		
		    	}else if (data.status==true) {
		    		document.querySelector('#rptaConsuta').innerHTML = '';
		    		document.querySelector('#resultadosTabla').innerHTML ='';
		    		var datos=data.datos;
		    		var i=1;
		    		for(item of datos){

				        var tr = `<tr>
				          <td>`+i+`</td>
				          <td>`+item.sala_nombre+`</td>
				          <td>`+item.sala_responsable+`</td>
				          <td>
				          <button class="btn btn-primary btn-sm" onClick="fnConsultar(${item.sala_id})"><i class="fa fa-edit"></i> Actuazlizar</button></td>
				        </tr>`;
				        $("#resultadosTabla").append(tr)
				        i++;
				      }    		
		    		$('#tabla').css('display','block');
		    		$('#tableListado').dataTable();
		    	}
		 	});
	  	} //FIN ELSE
	})

btnNuevoClase.addEventListener('click', function(event) {

	$('#ModalForm').modal('show');

})

function fnSearch(datos) {

	$.post( "../Controller/salasController.php?option=search",{query:datos})
  		.done(function( data ) {
    	if (data.status==false) {
    		 $("#resultadosTabla").innerHTML = '';
    		document.getElementById("nombreBusqueda").focus()
    		document.querySelector('#rptaConsuta').innerHTML = `<p class="text-danger">${data.message}</p>`;
    		
    	}else if (data.status==true) {
    		document.querySelector('#resultadosTabla').innerHTML ='';
    		var datos=data.datos;
    		var i=1;
    		for(item of datos){

		        var tr = `<tr>
		          <td>`+i+`</td>
		          <td>`+item.sala_nombre+`</td>
		          <td>`+item.sala_responsable+`</td>
		          <td>
		          <button class="btn btn-primary btn-sm" onClick="fnConsultar(${item.sala_id})"><i class="fa fa-edit"></i> Actuazlizar</button></td>
		        </tr>`;
		        $("#resultadosTabla").append(tr)
		        i++;
		      }    		
    		$('#tabla').css('display','block');
    		$('#tableListado').dataTable();
    	}
 	});

}

  function fnConsultar(item) {
  		
  		sala=item;
		  $('#rptaActualizarSala').css('display','none');
  		fetch('../Controller/salasController.php?option=select&query='+item)

		.then(response => response.json())
		.then(data => {

			if (data.status==false) {
				Swal.fire(
			      'Sala no encontrada',
			      '',
			      'error'
			    )
				 $('#rstaNuevaSala').css('display','block');
			}else if(data.status==true){
				
				var datos=data.datos;
				for(i of datos){
					 document.querySelector('#nombreu').value=i.sala_nombre;
					 document.querySelector('#responsableu').value=i.sala_responsable;
				}
				

				$('#modalFormUpdate').modal('show');			
			}
		})

  }

