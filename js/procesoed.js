/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
     function restablecerbuscarcolaborador(){
        $('#puestocolaborador').text('-');                             
        $('#busquedacolaborador').val('');                                              
        $('#idcolaborador').val('');                   
        $('#busquedacolaborador').removeAttr("disabled");
        $('#btnagregarcolaborador').attr('disabled', 'true');
        $("#imgborrarcolaborador").hide();
   }
   
   function cantidadcolaboradorestabla(){
      return $('#tblcolaboradores > tbody tr').length;       
   }
   
   function existeidcolaboradortabla(idcomprobar){
       var existe = false;
       $('#tblcolaboradores > tbody tr').each(function(index,columna){
           var idcolaborador = $(columna).find('td:eq(0)').text();//La columna cero posee el idcolaborador
           if (idcomprobar == idcolaborador)
               return existe = true;
       }            
       );
       return existe;           
   }
    
    $("#btnagregarcolaborador").click(function(){         
       
       var idevaluador = $('#idevaluador').val();  
       var cedula = $('#cedulacolaborador').val();
       var idcolaborador = $('#idcolaborador').val(); 
       var puesto = $('#puestocolaborador').text(); 
       var colaborador =  $('#busquedacolaborador').val(); 
       
       var urlimagenborrarcolaborador = "../../../images/icons/silk/delete.png";
       
       
       if(idevaluador == idcolaborador){
           messageerror('El colaborador no puede ser el mismo que el evaluador');
           restablecerbuscarcolaborador();
       }
       else if(cantidadcolaboradorestabla()==0){
           $('#tblcolaboradores > tbody').append('<tr><td name="idcolaborador" style="display: none">'+idcolaborador+'</td><td name="puesto">'+cedula+'</td><td name="colaborador">'+colaborador+'</td><td name="puesto">'+puesto+'</td><td><img id="borrarcolaborador" style="cursor: pointer; padding-left:5px;" src="'+urlimagenborrarcolaborador+'" alt="Eliminar colaborador"/></td></tr>');     
           restablecerbuscarcolaborador();
           ocultarerror($('#tblcolaboradores'));
       }
       else if (existeidcolaboradortabla(idcolaborador)){
           messageerror('El colaborador ya se encuentra seleccionado.');
           restablecerbuscarcolaborador();
       }
       else{
          $('#tblcolaboradores > tbody').append('<tr><td name="idcolaborador" style="display: none">'+idcolaborador+'</td><td name="puesto">'+cedula+'</td><td name="colaborador">'+colaborador+'</td><td name="puesto">'+puesto+'</td><td><img id="borrarcolaborador" style="cursor: pointer; padding-left:5px;" src="'+urlimagenborrarcolaborador+'" alt="Eliminar colaborador"/></td></tr>'); 
          restablecerbuscarcolaborador();
          ocultarerror($('#tblcolaboradores'));
       }

   });
    
    $("#btnbusquedacolaboradores").click(function(){              
       $("#dialogcolaboradores").dialog("open"); 
       
   });
   
   //Proceso crear evaluacion persona
   $("#btncrearprocesoevaluacion").click(function(event){
       event.preventDefault();
       $(this).attr("disabled", "disabled");
       
      if(validar($('#txtdescripcion')) && validar($('#id')) && validar($('#periodo'))){       
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
            if(!validar($('#periodo')))
                mostrarerror($('#periodo'));
      }
   });
   
   function obtenerdatos()
   {
       var data = {};
        data['txtdescripcion'] = $("#txtdescripcion").val();
        data['id'] = $("#id").val();
        data['periodo'] = $("#periodo").val();
    
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