$(document).ready(function() {
    
     //Guardar Compromisos    
     $("#btncompromisos").click(function(event){
       event.preventDefault();        
       
       ocultarerrorcompromisos();
       if (!validarcompromisos()){           
           messagewarning("Existen compromisos sin definir.");
       }  
       else if (!validar($('#dpFecha'))){
          mostrarerrorfecha($('#dpFecha'));
          messagewarning("Debe ingresar la fecha de evaluacion de los compromisos.");
       }           
       else{ 
       $('#btncompromisos').prop('disabled', true);
       $.ajax({
                    type: 'POST',
                    url: "../GuardarCompromisos",
                    data: obtenerdatoscompromisos(),
                    dataType: 'json',
                    error: function (jqXHR, textStatus){                    
                        $('#btncompromisos').removeAttr('disabled');
                        messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");                                    
                    },
                    success: function(datos){                          
                        if(datos.resultado)
                            messagesuccess(datos.mensaje, datos.url);              
                        else{
                            $('#btncompromisos').removeAttr('disabled');
                            messageerror(datos.mensaje);                            
                        }
                    }
        });}

   });
    
   function obtenerdatoscompromisos(){
       var data = {};
       data['ided'] = $("#lblided").text();       
       data['fecha'] = $("#dpFecha").val();
       data['compromisos'] = obtenercompromisos();
       data['comentario'] = $("#tacomentario").val();
       return data;
   }   
   
   function obtenercompromisos(){                 
       var compromisos = Array();
        $("#tblCompromisos > tbody > tr").each(function(index, fila) {		            
            var idpuntualizacion= $(fila).find('td:first').text(); 
            var compromiso= $(fila).find('#tacompromiso').val();  
            compromisos[index] = {"idPuntualizacion":idpuntualizacion,"compromiso":compromiso};
        });
        return compromisos;
   }

    //Guardar Evaluacion Desempeño
    $("#btnguardared").click(function(event){
        event.preventDefault();        
       
       ocultarerrorpuntualizaciones();
       ocultarerrorcompetencias();
       if (!validarpuntualizaciones()){           
           messagewarning("Existen compromisos sin calificar.");
       }  
       else if (!validarcompetencias()){         
          messagewarning("Existen competencias sin calificar.");
       }           
       else{ 
           $('#btnguardared').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: "../GuardarEvaluacionED",
                data: datosGuardarProceso(),
                dataType: 'json',
                error: function (jqXHR, textStatus){                    
                    $('#btnguardared').removeAttr('disabled');
                    messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");            
                },
                success: function(datos){
                    if(datos.resultado)
                        messagesuccess(datos.mensaje, datos.url);              
                    else{
                        $('#btnguardared').removeAttr('disabled');
                        messageerror(datos.mensaje);
                    }
                }
            });
        }
    });
    
    //Actualizar promedio de Puntualizaciones
    $("[name='puntajep']").change(function(){     
        actualizarCalificacion();
    });
    
    //Actualizar promedio de Competencias
    $("[name='puntajec']").change(function(){   
        actualizarCalificacion();
    });
    
    function actualizarCalificacion(){         
        $.ajax({
            type: "POST",
            url: "../ActualizarCalificacionED",
            data: datosActualizarCalificacion(),
            dataType: 'json',
            error: function (jqXHR, textStatus){
                messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");
            },
            success: function(datos){
                $
                $('.promediocompromisos > p > span').text(datos.puntualizaciones.toPrecision(3));
                $('#puntualizacionnivel').text(datos.puntualizaciones.toPrecision(3));
                $('.promediocompetencias > p > span').text(datos.competencias.toPrecision(3)); 
                $('#competenciasnivel').text(datos.competencias.toPrecision(3));
                $('#evaluacion').text(datos.ed.toPrecision(3));
                establecerColorRango(datos.ed.toPrecision(3));
            }
        });
    }
    
    function datosActualizarCalificacion(){             
        var data = {};
        data['puntualizaciones'] = obtenerCalificacionPuntualizaciones();
        data['competencias'] = obtenerCalificacionCompetencias();  
        return data;
    } 
    
    function datosGuardarProceso(){             
        var data = {};
        data['ided'] = $("#lblided").text();
        data['puntualizaciones'] = obtenerCalificacionPuntualizaciones();
        data['competencias'] = obtenerCalificacionCompetencias();        
        data['comentario'] = $("#tacomentario").val();
        return data;
    }    
    
    function obtenerCalificacionPuntualizaciones(){
        var puntualizaciones = {};       
        $("#tblcompromisos > tbody > tr").each(function(index, fila) {		
            var idcompromiso = $(fila).find('td:first').text();
            var calificacion = $(fila).find('#ddlpuntajecompromisos').val();            
            puntualizaciones[index] = {
                "idcompromiso":idcompromiso, 
                "calificacion":calificacion
            }
        });
        return puntualizaciones;
    }
    
    function obtenerCalificacionCompetencias(){
        var competencias = {};
        $("#tblcompetencia > tbody > tr").each(function(index, fila) {		
            var idcompetencia= $(fila).find('td:first').text();            
            var tipocompetencia= $(fila).find('#tipocompetencia').text();            
            var calificacion= $(fila).find('#ddlpuntajecompetencias').val();
            var ponderacion = $(fila).find('td:last').text();
            competencias[index] = {
                "idcompetencia":idcompetencia,
                "tipocompetencia":tipocompetencia,
                "calificacion":calificacion, 
                "ponderacion":ponderacion
            }
        });
        return competencias;
    }
    
    function establecerColorRango(valorfinal) {
        var superior = 5;
        var sobresaliente = 4;
        var esperado = 3;
        var mejora = 2 
            
        $('.table_evaluacion_resultado').css('margin', '0 50px 0 180px');//Conservar la posicion de las tablas                         
        $('#rango').removeClass(); 
        $('#rango').empty();
            
        if(parseFloat(valorfinal) == superior){
            $('#rango').addClass('superior');                
            $('#rango').html($('#superior').html());
        }else if (parseFloat(valorfinal) >= sobresaliente){
            $('#rango').addClass('sobresaliente');                
            $('#rango').html($('#sobresaliente').html());
        }else if (parseFloat(valorfinal) >=  esperado){
            $('#rango').addClass('esperado');                
            $('#rango').html($('#esperado').html());
        }else if (parseFloat(valorfinal) >= mejora){
            $('#rango').addClass('mejora');                
            $('#rango').html($('#mejora').html());
        }else{
            $('#rango').addClass('insuficiente');                
            $('#rango').html($('#insuficiente').html());
        }
    }
    
    function validar(elemento){
        if($(elemento).val() == '' || $(elemento).val()=='-')
            return false;
        else
            return true;
    }

    function mostrarerror(elemento){      
        $(elemento).next().show();
    }
    
    function ocultarerror(elemento){       
        $(elemento).next().hide();
    }
    
    
    ///COMPROMISOS VALIDACIONES
    function mostrarerrorfecha(elemento){
       $(elemento).next().next().show();
   }
   
    function validarcompromisos(){
    var valido = true;      
        $("#tblCompromisos > tbody > tr").each(function(index, fila) {                                 
            if($.trim($(fila).find('#tacompromiso').val()) == '')
            {
                valido = false;
                mostrarerror($(fila).find('#tacompromiso'));                         
            }
        });
    return valido;   
   }
   
    function ocultarerrorcompromisos(){
            $("#tblCompromisos > tbody > tr").each(function(index, fila) {                                 
                $(fila).find('#tacompromiso').next().hide();
            });
        }   
        
    //PUNTUALIZACIONES VALIDACIONES
    
    function validarpuntualizaciones(){
    var valido = true;      
        $("#tblcompromisos > tbody > tr").each(function(index, fila) {                                 
            if($.trim($(fila).find('#ddlpuntajecompromisos').val()) == '')
            {
                valido = false;
                mostrarerror($(fila).find('#ddlpuntajecompromisos'));                         
            }
        });
    return valido;   
   }
   
    function ocultarerrorpuntualizaciones(){
            $("#tblcompromisos > tbody > tr").each(function(index, fila) {                                 
                $(fila).find('#ddlpuntajecompromisos').next().hide();
            });
        }  
    
    //COMPETENCIAS VALIDACIONES
    
    function validarcompetencias(){
    var valido = true;      
        $("#tblcompetencia > tbody > tr").each(function(index, fila) {                                 
            if($.trim($(fila).find('#ddlpuntajecompetencias').val()) == '')
            {
                valido = false;
                mostrarerror($(fila).find('#ddlpuntajecompetencias'));                         
            }
        });
    return valido;   
   }
    
    function ocultarerrorcompetencias(){
            $("#tblcompetencia > tbody > tr").each(function(index, fila) {                                 
                $(fila).find('#ddlpuntajecompetencias').next().hide();
            });
        } 
    
    //MENSAJES

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
    
    function messagewarning(message){
        new Messi(message,
        {   
            title: 'Advertencia', 
            titleClass: 'anim warning',                                 
            modal:true
        });
    }

});