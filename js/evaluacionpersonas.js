$(document).ready(function() {
   
   //Proceso crear evaluacion persona
   $("#btncrearevaluacionpersona").click(function(event){
       event.preventDefault();
       
      if(validar($('#txtdescripcion')) && validar($('#ddlpuesto'))){       
       $.ajax({
                    type: "POST",
                    url: "Crear",
                    data: obtenerdatoscrearpersona(),
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
                            messagesuccess(resultado.value);
                        }else{
                            messageerror(resultado.value);
                        }                        
                    }
        });
      }
      else{
          if(!validar($('#txtdescripcion')))
                mostrarerror($('#txtdescripcion'));
           if(!validar($('#ddlpuesto')))
                mostrarerror($('#ddlpuesto'));
      }
   });
  
    function obtenerdatoscrearpersona(){             
    var data = {};
    data['proceso'] = $("#txtdescripcion").val();
    data['puesto'] = $("#ddlpuesto").val(); 

    if(cantidadhabilidades() > 0){
        var habilidades = {};
        $("#tblhabilidades > tbody > tr").each(function(index, value) {		
            var habilidad = $(value).find('td:eq(0)').text();	
            var descripcion = $(value).find('td:eq(1)').text();					
            habilidades[habilidad] = descripcion;
        });
        data['habilidades'] = habilidades;
    }
    return data;
   }
   
   //Gestion dialog habilidades especiales
   $("#btndialoghabilidadespecial").click(function(){       
       limpiarinputshabilidades();
       $("#divhabilidad").show();       
       $("#dialogHabilidades").dialog('open');
   });
   

   
   $(document).on("click", "#borrarhabilidad", function(e){
        $(this).parents("tr").remove()
        if (cantidadhabilidades() < 5){
           $("#btndialoghabilidadespecial").removeAttr('disabled');        
        }
   });
   
   $("#btncrearhabilidad").click(function(){         
       
       if(validar($('#txtnombrehabilidad')) && validar($('#txtareadescripcionhabilidad'))){       
        var habilidad = $('#txtnombrehabilidad').val();
        var habilidaddescripcion = $('#txtareadescripcionhabilidad').val();                
        $('#tblhabilidades > tbody').append('<tr><td name="habilidad">'+habilidad+'</td><td name="descripcion">'+habilidaddescripcion+'</td><td><img id="borrarhabilidad" style="cursor: pointer;" src="../../images/icons/silk/delete.png" alt="Eliminar habilidad"/></td></tr>');               
        if (cantidadhabilidades() >= 5){
            $("#btndialoghabilidadespecial").attr("disabled", "disabled");        
        }       
        $("#dialogHabilidades").dialog('close');
       }else{
           if(!validar($('#txtnombrehabilidad')))
                mostrarerror($('#txtnombrehabilidad'));
           if(!validar($('#txtareadescripcionhabilidad')))
                mostrarerror($('#txtareadescripcionhabilidad'));
       }
   });
   
   function cantidadhabilidades(){
      return $('#tblhabilidades > tbody tr').length;       
   }
   
   $('#txtnombrehabilidad').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));                           
   });   
   $('#txtnombrehabilidad').focusin(function(){
        ocultarerror($(this));  
   });
   
   $('#txtareadescripcionhabilidad').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });
   $('#txtareadescripcionhabilidad').focusin(function(){
        ocultarerror($(this)); 
   });
   
   $('#txtdescripcion').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });
   $('#txtdescripcion').focusin(function(){
        ocultarerror($(this)); 
   });
   
   $('#ddlpuesto').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });
   $('#ddlpuesto').focusin(function(){
        ocultarerror($(this)); 
   });
   
   function limpiarinputshabilidades(){
       $('#txtnombrehabilidad').val('');
       $('#txtareadescripcionhabilidad').val('');
       ocultarerror($('#txtnombrehabilidad'));
       ocultarerror($('#txtareadescripcionhabilidad'));
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
    
    function messagesuccess(message){         
        new Messi(message, 
        {   title: 'Éxito.', 
            titleClass: 'success',                                 
            modal:true,
            closeButton: false,
            buttons: [{id: 0, label: 'Cerrar', val: 'X'}],
            callback: function(val){var url = "admin/";    
                                    $(location).attr('href',url);}
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
    
    
    //Pertenece a la vista agregarpersona
    $("#formagregarpersona").submit(function(event){
       event.preventDefault();   
       
       //if(validar($('#cedula')) && validar($('#colaborador')) && validar($('#tipo'))&& validar($('#id')))
       if(validar('#colaborador') && validar('#colaborador') && validar('#tipo')&& validar('#id'))
       {
            $.ajax({
                        type: "POST",
                        url: "../agregarpersona",  
                        data: $("#formagregarpersona").serialize(),
                        dataType: "json",
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
                                $.fn.yiiGridView.update('historial-grid');                                                                                    
                                $('#btnagregarpersona').removeAttr('disabled');                                                        

                            }else{
                                messageerror(resultado.value);
                            }                       

                        }
                });

                $('#cedula').text('-');                             
                $('#colaborador').val('');                                              
                $('#id').val('');                              
                $('#tipo').val('');                             
                $('#colaborador').removeAttr("disabled");
                $('#btnagregarpersona').attr('disabled', 'true');	
                $("#imgborrar").hide();
                
       }       

            
        });

   $("#imgborrar").on("click",function(){        
       
          $('#cedula').text('-');                             
                $('#colaborador').val('');                                              
                $('#id').val('');                              
                $('#tipo').val('');                             
                $('#colaborador').removeAttr("disabled");
                $('#btnagregarpersona').attr('disabled', 'true');
                $("#imgborrar").hide();
   });
   
    
    
});

