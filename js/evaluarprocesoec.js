$(document).ready(function() {

    //Guardar Evaluacion Competencias
    $("#btnguardarec").click(function(event){
        event.preventDefault();
       if(false){}//VALIDACIONES
//        if(!validar($('#ddlperiodo'))){     
//            mostrarerror($('#ddlperiodo'));
//        }
//        else if (!validar($('#txtdescripcion'))){
//            mostrarerror($('#txtdescripcion'));
//        }
//        else if (!validar($('#busquedaevaluador'))){
//            mostrarerror($('#busquedaevaluador'));
//        }
//        else if (cantidadcolaboradorestabla()== 0){
//            mostrarerror($('#tblcolaboradores'));
//        }
        else{
            $.ajax({
                type: "POST",
                url: "../GuardarProcesoEC",
                data: obtenerdatosguardarproceso(),
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
   
    function obtenerdatosguardarproceso(){             
        var data = {};
        data['idec'] = $("#lblidec").text();        
        data['meritos'] = obtenercalificacionmeritos();    
        data['habilidades'] = obtenercalificacionhabilidades(); 
        data['habilidadesnoequivalentes'] = obtenercalificacionhabilidadesnoequivalentes(); 
        return data;
    }
    
    function obtenercalificacionmeritos(){
        var meritos = {};       
        $("#tblmeritos > tbody > tr").each(function(index, fila) {		
            var idmerito = $(fila).find('td:first').text();
            var calificacionmerito = $(fila).find('#ddlpuntajemeritos').val();
            var ponderacion = $(fila).find('td:last').text();
            meritos[index] = {"idmerito":idmerito, "calificacionmerito":calificacionmerito, "ponderacion":ponderacion}
        });
        return meritos;
        
    }
    
    function obtenercalificacionhabilidades(){
        var habilidades = {};
        $("#tblhabilidadec > tbody > tr").each(function(index, fila) {		
            var idhabilidad= $(fila).find('td:first').text();            
            var tipohabilidad= $(fila).find('td:eq(1)').text(); 
            var metodoseleccionado = $(fila).find('#tfmetodoseleccionado').val()
            var variableequivalente = $(fila).find('#tfvariablequivalente').val();
            var calificacionequivalente = $(fila).find('#tfcalificacionvariablequivalente').val();
            var calificacionhabilidad = $(fila).find('#ddlpuntajehabilidades').val();
            var ponderacion = $(fila).find('td:last').text();
            habilidades[index] = {"idhabilidad":idhabilidad,"tipohabilidad":tipohabilidad, "metodoseleccionado":metodoseleccionado, "variableequivalente":variableequivalente, "calificacionequivalente":calificacionequivalente,"calificacionhabilidad":calificacionhabilidad, "ponderacion":ponderacion}
        });
        return habilidades;
    }
   
    function obtenercalificacionhabilidadesnoequivalentes(){
        var habilidadesnoequivalentes = {};       
        $("#tblhabilidadnoequivalente > tbody > tr").each(function(index, fila) {
            if($(fila).find('#tfmetodovariablenoquivalente').val()===""){
                return true;
            }else{                           
                var metodovariablenoquivalente = $(fila).find('#tfmetodovariablenoquivalente').val();
                var variablenoquivalente = $(fila).find('#tfvariablenoquivalente').val();
                var competencia = $(fila).find('#ddlcompetencia').val();
                var calificacionvariablenoquivalente = $(fila).find('#ddlpuntajenoequivalente').val();
                var puesto1 = $(fila).find('#ddlpuesto1').val();
                var puesto2 = $(fila).find('#ddlpuesto2').val();               
                habilidadesnoequivalentes[index] = {"metodovariablenoquivalente":metodovariablenoquivalente, "variablenoquivalente":variablenoquivalente, "competencia":competencia,"calificacionvariablenoquivalente":calificacionvariablenoquivalente,"puesto1":puesto1, "puesto2":puesto2}
            }
        });
        return habilidadesnoequivalentes;
    }
    
    $("[name='puntaje']" ).change(function(){        
        var promedio = 0;
        var dividendo = 0;
        var divisor = 0;
        $("[name='puntaje']" ).each(function() {
                var calificacion = $(this).val();                
                var ponderado = parseInt($(this).parent().parent().find('td:last').text());
                if(calificacion === ""){
                    calificacion = 0;
                    dividendo = dividendo + calificacion * ponderado;  
                    divisor = divisor + ponderado;                   
                }else{
                    calificacion = parseInt(calificacion);
                    dividendo = dividendo + calificacion * ponderado;  
                    divisor = divisor + ponderado;                  
                }                                
        });    
        promedio = dividendo / divisor;
        $('.promedioponderado > p > span').text(promedio.toPrecision(3));
    });
    
});