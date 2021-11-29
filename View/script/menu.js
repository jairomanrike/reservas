$( document ).ready(function() {
    
    fetch('../Controller/menuController.php')

	.then(response => response.json())
	.then(data => {
		if (data.status==false) {
		}else if(data.status==true){
				const padre=document.getElementById('rptaMenu');
				let item;
				let a;
 				var datos = data.datos;
 				for (let items of datos) {

 					$('#rptaMenu').append('<li class="nav-item">'+
 										  '<a class="nav-link active" aria-current="page" href="'+items.modu_url+'">'+items.modu_nombre+'</a>' 
 										 +'</li>')
 				}					
		}
	})
});