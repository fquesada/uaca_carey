$(document).ready(function() {

    //Guardar Evaluacion Competencias
    $("#btnguardarec").click(function(event){
        event.preventDefault();        
        ocultarerrornoequivalente($('#habilidadnoequivalenteerror'));
        if(!validarcalificacionhabilidadesnoequivalentes()){            
            messagewarning("Ha ingresado una o mas Habilidades No Equivalentes al Puesto incompletadas.");
        }        
        else if(!validarcalificacionac($('#ddlpuntajeassessmentcenter'))){          
           mostrarerror($('#ddlpuntajeassessmentcenter'));                     
           messagewarning("El assessment center debe ser calificado.");
        }
        else if (!validarcalifacionmeritohabilidades()){
            messagewarning("Existen Meritos o Habilidades sin calificar.");
        }
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
    $('#ddlpuntajeassessmentcenter').focusout(function(){
        if(!validarcalificacionac($(this)))          
            mostrarerror($(this));     
    });
    $('#ddlpuntajeassessmentcenter').focusin(function(){
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
            if($(elemento).val() == '' || $(elemento).val()=='-')
                return false;
            else
                return true;
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
            if($(fila).find('#tfmetodovariablenoquivalente').val()===""){
                return true;
            }else{                           
                if($(fila).find('#tfmetodovariablenoquivalente').val() == '' || $(fila).find('#tfvariablenoquivalente').val() == '' || $(fila).find(('#ddlcompetencia')).val() == '' || $(fila).find('#ddlpuesto1').val() == '' || $(fila).find('#ddlpuesto2').val() == '')
                {
                    valido = false;
                    mostrarerrornoequivalente($('#habilidadnoequivalenteerror'));                         
                }
            }
        });
        return valido;
    }
    
    function obtenerdatosguardarproceso(){             
        var data = {};
        data['idec'] = $("#lblidec").text();
        data['ac'] = obtenercalificacionac();
        data['meritos'] = obtenercalificacionmeritos();    
        data['habilidades'] = obtenercalificacionhabilidades(); 
        data['habilidadesnoequivalentes'] = obtenercalificacionhabilidadesnoequivalentes(); 
        return data;
    }
    
    function obtenercalificacionac(){
        var ac = {};
        var indicadorac = false;
        var calificacionac = 0;
        var detalleac = "";
 
        if($("#cbassessmentcenter").is(":checked")){            
            detalleac = $("#taassessmentcenter").val();
            indicadorac = true;      
            if(!(califacionac() === ""))
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
        return $("#ddlpuntajeassessmentcenter").val();
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
        if(calificacionac === ""){
                    calificacionac = 0;}       
        var promedioec = promediomeritoshabilidades();
        formulapromedioacec(calificacionac, promedioec);
    }
    
    function actualizarec(){
        var calificacionac = 0;        
        var promedioec = promediomeritoshabilidades();
        
        if($("#cbassessmentcenter").is(":checked")){            
            calificacionac =  califacionac();      
            if(calificacionac === ""){
                    calificacionac = 0;}        
            formulapromedioacec(calificacionac, promedioec);
        }else{
        actualizarpromedio(promedioec);}
    }
    
    function actualizarindicadorac(){
        actualizarec();
        $("#taassessmentcenter").val('');
        $("#ddlpuntajeassessmentcenter").val('');
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