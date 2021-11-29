let validation=false;
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }else{
          event.preventDefault();         
          loginValidation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

// FUNCTIONS PARA VALIDAR LAS VARIABLES DE INICIO DE SESION
  
  function loginValidation(){
    
    var User = document.getElementById('user').value;
    var Pass = document.getElementById('password').value;

    if (User=='' || User==null){
      document.getElementById('user').focus();
    }else{
      if (Pass=='' || Pass==null){
        document.getElementById('password').focus(); 
      }else{
        validation = true;
      }      
    }

    if (validation){
      loginAuthentication(User,Pass)
    }

  }

  function loginAuthentication(strUser,strPass){

    $.ajax({
      method: "POST",
      url: "Controller/loginController.php",
      data: { user: strUser, password: strPass }
    })
      .done(function(data) {
          if(data.status==true){

               location.href = data.url;

          }else{
             document.querySelector("#respuesta").innerHTML = `<div class="alert alert-danger alert-dismissible" role="alert">`
                                                                +data.message+
                                                                `<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                </div>`;
          }
      })     

  }