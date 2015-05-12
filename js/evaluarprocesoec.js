$(document).ready(function() {

    //Guardar Evaluacion Competencias
    $("#btnguardarec").click(function(event){
        event.preventDefault();        
        ocultarerrornoequivalente($('#habilidadnoequivalenteerror'));
        if(!validarcalificacionhabilidadesnoequivalentes()){            
            messagewarning("Ha ingresado una o mas Habilidades No Equivalentes al Puesto incompletadas.");
        }        
        else if(!validarcalificacionac($('#tfpuntajeassessmentcenter'))){          
           mostrarerror($('#tfpuntajeassessmentcenter'));                     
           messagewarning("El assessment center debe ser calificado.");
        }
        else if (!validarcalifacionmeritohabilidades()){
            messagewarning("Existen Meritos o Habilidades sin calificar.");
        }
        else{
            $('#btnguardarec').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: "../GuardarEvaluacionEC",
                data: obtenerdatosguardarproceso(),
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
    
    function califacionac(){
        if(!validarcalificacionac($('#tfpuntajeassessmentcenter')))
           return 0;        
        else 
            return parseFloat($("#tfpuntajeassessmentcenter").val().replace(',','.'));
    }    
     
    function actualizarpromedio(promedio){
        $('.promedioponderado > p > span').text(promedio.toPrecision(3));
    }    
 
    function actualizarcalificacion(){    
        $.ajax({
            type: "POST",
            url: "../ActualizarCalificacionEC",
            data: obtenerdatosguardarproceso(),
            dataType: 'json',
            error: function (jqXHR, textStatus){
                messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");
            },
            success: function(datos){
              actualizarpromedio(datos.calificacionec);
            }
        });
    }
    
    function actualizarindicadorac(){
        actualizarcalificacion();
        $("#taassessmentcenter").val('');
        $("#tfpuntajeassessmentcenter").val('');
        $("#divassessmentcenter").toggle("fast");
    }
    
    $("[name='puntajeac']").change(function(){        
            actualizarcalificacion();
    });
    
    $("[name='puntaje']" ).change(function(){               
            actualizarcalificacion();
    });       

    $("#cbassessmentcenter" ).on( "click", function() {           
            actualizarindicadorac();        
    });
});