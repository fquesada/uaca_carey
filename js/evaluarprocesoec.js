$(document).ready(function() {

    //Guardar Evaluacion Competencias
    $("#btnguardarec").click(function(event){
        event.preventDefault();
       
        if(!validar($('#ddlperiodo'))){     
            mostrarerror($('#ddlperiodo'));
        }
        else if (!validar($('#txtdescripcion'))){
            mostrarerror($('#txtdescripcion'));
        }
        else if (!validar($('#busquedaevaluador'))){
            mostrarerror($('#busquedaevaluador'));
        }
        else if (cantidadcolaboradorestabla()== 0){
            mostrarerror($('#tblcolaboradores'));
        }
        else{
            $.ajax({
                type: "POST",
                url: "CrearProcesoEC",
                data: obtenerdatoscrearproceso(),
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
                success: function(datos){
                    if(datos.resultado)
                        messagesuccess(datos.mensaje, datos.url);              
                    else
                        messageerror(datos.mensaje);
                }
            });
        }
    });
        
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
        {
            title: 'Éxito.', 
            titleClass: 'success',                                 
            modal:true,
            closeButton: false,
            buttons: [{
                id: 0, 
                label: 'Cerrar', 
                val: 'X'
            }],
            callback: function(val){
                window.location.replace(url);
            }            
        });
    }
    
    function messageerror(message){
        new Messi(message,
        {   
            title: 'Alerta', 
            titleClass: 'anim error',                                 
            modal:true                                          
        });
    }      
   
    $("#imgescalacalificacion").click(function(){              
        $("#divescalacalificacion").show();       
        $("#infoescalacalificacion").dialog('open');      
    });
   
    function obtenerdatoscrearproceso(){             
        var data = {};
        data['nombreproceso'] = $("#txtdescripcion").val();
        data['idevaluador'] = $("#idevaluador").val(); 
        data['periodo'] = $('#ddlperiodo').val();
        data['colaboradores'] = obtenercolaboradoresevaluar();    
        return data;
    }
    
    function obtenercalificacionmeritos(){
        
    }
    
    function obtenercalificacionhabilidades(){
        
    }
   
    function obtenercalificacionhabilidadesnoequivalentes(){
        
    }
    
    function obtenercolaboradoresevaluar(){                 
        var colaboradores = Array();
        $("#tblcolaboradores > tbody > tr").each(function(index, columna) {		
            var idcolaborador = $(columna).find('td:eq(0)').text();	            
            colaboradores[index] = idcolaborador;
        });
        return colaboradores;
    }
   
});