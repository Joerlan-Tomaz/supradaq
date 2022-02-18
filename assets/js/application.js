$(document).ready(function(){
    $("#btn-entrar").click(function(){
            
           // alert('oi===='+serializedData);
              if($("#nume_matricula").val()==""){ 
                $.notify("Por favor, informe o seu \"Email\".", 'info');             
                $("#nume_matricula").focus();
                return false; 
              }
              if($("#codi_senha").val()==""){ 
                $.notify("Por favor, informe a sua \"Senha\".", 'info');
                $("#codi_senha").focus();
                return false; 
              }
              var BASE_URL = '<?php echo base_url(); ?>';
              var serializedData = $("#form_login").serialize();
              $.ajax({
                  url: 'http://localhost:8080/Ci/index.php/application/validar_login',
                  type: 'POST',
                  data: serializedData,

                    success: function(retorno){
                        //$.notify('Operação [ Reset de senha ] efetuado com sucesso', "success"); 
                        if(retorno=14){
                          console.log('oi======'+ retorno);
                          $.ajax({
                              url: 'http://localhost:8080/Ci/index.php/application/ajax_redirect', 
                              type: 'POST',
                              data: {
                                        location: 'index.php/application/home'             
                                    }  
                          });         
                        }
                        
                    }
                    
              });

              
    });
});     