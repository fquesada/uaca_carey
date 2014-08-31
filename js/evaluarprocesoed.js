$(document).ready(function() {
    
    //Compromisos
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
                        $('#btncompromisos').prop('disabled', false);
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
        
        //        ocultarerrornoequivalente($('#habilidadnoequivalenteerror'));
        //        if(!validarcalificacionhabilidadesnoequivalentes()){            
        //            messagewarning("Ha ingresado una o mas Habilidades No Equivalentes al Puesto incompletadas.");
        //        }        
        //        else if(!validarcalificacionac($('#tfpuntajeassessmentcenter'))){          
        //           mostrarerror($('#tfpuntajeassessmentcenter'));                     
        //           messagewarning("El assessment center debe ser calificado.");
        //        }
        //        else if (!validarcalifacionmeritohabilidades()){
        //            messagewarning("Existen Meritos o Habilidades sin calificar.");
        //        }
        if (false)
            false;
        else{
            $.ajax({
                type: "POST",
                url: "../GuardarEvaluacionED",
                data: datosGuardarProceso(),
                dataType: 'json',
                error: function (jqXHR, textStatus){                    
                messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");            
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
    
    
    
    ///////////////////////////////BASE DE EC
    
    
    
    
    function ajustarvistaerror(elemento){
        $('html, body').animate({
                scrollTop: $(elemento).offset().top + $(elemento).height()/2 - $(window).height()/2
        }, 400);
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
   
    $("#imgescalacalificacion").click(function(){              
        $("#divescalacalificacion").show();       
        $("#infoescalacalificacion").dialog('open');      
    });

    //Validacion de campos
    $('#tfpuntajeassessmentcenter').focusout(function(){
        if(!validarcalificacionac($(this)))                     
            mostrarerror($(this));
    });
    $('#tfpuntajeassessmentcenter').focusin(function(){
        ocultarerror($(this)); 
    });
    
    $("[name='puntaje']").focusout(function(){
        if(!validar($(this)))          
            mostrarerror($(this));     
    });
    $("[name='puntaje']").focusin(function(){
        ocultarerror($(this)); 
    });
    
    function validarcalificacionac(elemento){
        if($('#cbassessmentcenter').is(":checked")){                                  
            var ac = $(elemento).val();
            if(!(ac == '')){
                if(!(isNaN(parseFloat(ac)) || isNaN(Number(ac.replace(',','.'))))){
                    var acnumero = parseFloat(ac.replace(',','.'));
                    if(!(acnumero < 0 || acnumero > 5)){
                        return true;
                    }
                    else
                        return false;
                }
                else
                    return false;
            }
            else
                return false;
        }else
            return true;
    }    
    
    function validarcalifacionmeritohabilidades(){
        var valido = true;
        $("[name='puntaje']" ).each(function() {
              if($(this).val() == '' || $(this).val()=='-'){
                  valido = false;
                  mostrarerror($(this)); 
              }
        });
        return valido;
    }
    
    function mostrarerrornoequivalente(elemento){      
        $(elemento).show();
    }
    
    function ocultarerrornoequivalente(elemento){       
        $(elemento).hide();
    }
    
    function validarcalificacionhabilidadesnoequivalentes(){
        var valido = true;      
        $("#tblhabilidadnoequivalente > tbody > tr").each(function(index, fila) {
            if(validarfilacalificacionhabilidadesnoequivalentes(fila)){
                return true;
            }else{                           
                if($.trim($(fila).find('#tfmetodovariablenoquivalente').val()) == '' || $.trim($(fila).find('#tfvariablenoquivalente').val()) == '' || $(fila).find(('#ddlcompetencia')).val() == '' || $(fila).find('#ddlpuntajenoequivalente').val() == '' || $(fila).find('#ddlpuesto1').val() == '' || $(fila).find('#ddlpuesto2').val() == '')
                {
                    valido = false;
                    mostrarerrornoequivalente($('#habilidadnoequivalenteerror'));                         
                }
            }
        });
        return valido;
    }
    
    function validarfilacalificacionhabilidadesnoequivalentes(fila){
        var valido = true;
        if($.trim($(fila).find('#tfmetodovariablenoquivalente').val()) != ''){
            valido = false;
        }else if($.trim($(fila).find('#tfvariablenoquivalente').val()) != ''){
            valido = false;
        }else if($(fila).find(('#ddlcompetencia')).val() != ''){
            valido = false;
        }else if($(fila).find('#ddlpuntajenoequivalente').val() != ''){
             valido = false;
        }        
        else if ($(fila).find('#ddlpuesto1').val() != ''){
            valido = false;
        }else if ($(fila).find('#ddlpuesto2').val() != ''){
            valido = false;
        }            
        return valido;    
    }
    
    
    
    function obtenercalificacionac(){
        var ac = {};
        var indicadorac = false;
        var calificacionac = 0;
        var detalleac = "";
 
        if($("#cbassessmentcenter").is(":checked")){            
            detalleac = $("#taassessmentcenter").val();
            indicadorac = true;      
            calificacionac = califacionac();
        }        
        ac['indicadorac'] = indicadorac;
        ac['calificacionac'] = calificacionac;
        ac['detalleac'] = detalleac;        
        
        return ac;        
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
            var metodoseleccionado = $(fila).find('#ddlmetodoseleccionado').val()
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
      
    function promediomeritoshabilidades(){
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
        return promedio = dividendo / divisor;
    }
    
    function califacionac(){
        if(!validarcalificacionac($('#tfpuntajeassessmentcenter')))
           return 0;        
        else 
            return parseFloat($("#tfpuntajeassessmentcenter").val().replace(',','.'));
    }
    
    function formulapromedioacec(promedioac, promedioec){       
        var promedio = (promedioac * 0.60) + (promedioec * 0.40);        
        actualizarpromedio(promedio);
    }   
    
    function actualizarpromedio(promedio){
        $('.promedioponderado > p > span').text(promedio.toPrecision(3));
    }
    
    function actualizaracac(){
        var calificacionac =  califacionac();       
        var promedioec = promediomeritoshabilidades();
        formulapromedioacec(calificacionac, promedioec);
    }
    
    function actualizarec(){
        var calificacionac = 0;        
        var promedioec = promediomeritoshabilidades();
        
        if($("#cbassessmentcenter").is(":checked")){            
            calificacionac =  califacionac();             
            formulapromedioacec(calificacionac, promedioec);
        }else{
        actualizarpromedio(promedioec);}
    }
    
    function actualizarindicadorac(){
        actualizarec();
        $("#taassessmentcenter").val('');
        $("#tfpuntajeassessmentcenter").val('');
        if($("#cbassessmentcenter").is(":checked"))
            $("#divassessmentcenter").toggle("fast");
        else           
            $("#divassessmentcenter").toggle("fast");
    }
    
    $("[name='puntajeac']").change(function(){        
            actualizaracac();
    });
    
    $("[name='puntaje']" ).change(function(){               
        actualizarec();
    });       

    $("#cbassessmentcenter" ).on( "click", function() {           
            actualizarindicadorac();        
    });
});