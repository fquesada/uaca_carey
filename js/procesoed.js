/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
   
   //Proceso crear evaluacion persona
   $("#btncrearprocesoevaluacion").click(function(event){
       event.preventDefault();
       
      if(validar($('#txtdescripcion')) && validar($('#id'))){       
       $.ajax({
                    type: "POST",
                    url: "Crear",               
                    data: obtenerdatos(),
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        if (jqXHR.status === 0) {                            
                            messageerror("Problema de red, contacte al administrador de sistemas.");
                        } else if (jqXHR.status == 404) {
                            messagewarning("Solicitud no encontrada.");
                        } else if (jqXHR.status == 500) {
                            messageerror("Error 500. Ha ocurrido un problema con el servidor, contacte al administrador de sistemas.");
                        } else if (textStatus === 'parsererror') {
                            messagewarning("Ha ocurrido un inconveniente, intente nuevamente.");
                        } else if (textStatus === 'timeout') {
                            messageerror("Tiempo de espera excedido, intente nuevamente.");
                        } else if (textStatus === 'abort') {
                            messageerror("Se ha abortado la solicitud, intente nuevamente");
                        } else {
                            messageerror("Error desconocido, contacte al administrador de sistemas.");                            
                        }
                    },
                    success: function(resultado){
                        if(resultado.result){
                            messagesuccess(resultado.value, 'admin/');
                        }else{
                            messageerror(resultado.value);
                        }                        
                    }
        });
      }
      else{
          if(!validar($('#txtdescripcion')))
                mostrarerror($('#txtdescripcion'));
           if(!validar($('#id')))
                mostrarerror($('#colaborador'));
      }
   });
   
   function obtenerdatos()
   {
       var data = {};
        data['txtdescripcion'] = $("#txtdescripcion").val();
        data['id'] = $("#id").val();
    
        return data;
   }
   
      
   function validar(elemento){
       if($(elemento).val() == '' || $(elemento).val()=='-')
           return false;
       else
           return true;
   }

    function mostrarerror(elemento){
        $('#'+$(elemento).attr('id')+'error').css('visibility', 'visible');
    }
    
    function ocultarerror(elemento){
        $('#'+$(elemento).attr('id')+'error').css('visibility', 'hidden');
    }
    
    function messagesuccess(message, url){         
        new Messi(message, 
        {   title: 'Éxito.', 
            titleClass: 'success',                                 
            modal:true,
            closeButton: false,
            buttons: [{id: 0, label: 'Cerrar', val: 'X'}],
            callback: function(val){$(location).attr('href',url);}
        });
    }
    
    function messageerror(message){
        new Messi(message,
        {   
            title: 'Error', 
            titleClass: 'anim error',                                 
            modal:true                                          
        });
    }
    
    function messagewarning(message){
        new Messi(message,
        {   
            title: 'Advertencia', 
            titleClass: 'anim warning',                                 
            modal:true
        });
    }
    
});