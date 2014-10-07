$(document).ready(function() {
    
    //Guardar proceso de editar EC
    $("#btnguardarprocesoEC").click(function(event){
        event.preventDefault();      
        
        var idprocesoec = $('#idprocesoec').val();
        
        if(!validar($('#ddlperiodo'))){     
            mostrarerror($('#ddlperiodo'));}
       else if (!validar($('#txtdescripcion'))){
            mostrarerror($('#txtdescripcion'));}
       else if (!validar($('#busquedaevaluador'))){
           mostrarerror($('#busquedaevaluador'));}
       else if (cantidadcolaboradorestabla()== 0){
           mostrarerror($('#tblcolaboradores'));
       }
       else{
           $('#btnguardarprocesoEC').attr('disabled', 'true');
           $.ajax({
                    type: "POST",
                    url: "../editarprocesoec/"+idprocesoec,
                    data: obtenerdatoscrearproceso(),
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        $('#btnguardarprocesoEC').removeAttr('disabled');
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
   
   //Crear Proceso de Evaluacion Competencias
   $("#btncrearprocesoEC").click(function(event){
       event.preventDefault();       
       
       if(!validar($('#ddlperiodo'))){     
            mostrarerror($('#ddlperiodo'));}
       else if (!validar($('#txtdescripcion'))){
            mostrarerror($('#txtdescripcion'));}
       else if (!validar($('#busquedaevaluador'))){
           mostrarerror($('#busquedaevaluador'));}
       else if (cantidadcolaboradorestabla()== 0){
           mostrarerror($('#tblcolaboradores'));
       }
       else{         
       $('#btncrearprocesoEC').attr('disabled', 'true');
       $.ajax({
                    type: "POST",
                    url: "CrearProcesoEC",
                    data: obtenerdatoscrearproceso(),
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        $('#btncrearprocesoEC').removeAttr('disabled');
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
//      }
//      else{
//          if(!validar($('#txtdescripcion')))
//                mostrarerror($('#txtdescripcion'));
//           if(!validar($('#ddlpuesto')))
//                mostrarerror($('#ddlpuesto'));
//      }
   });
   
   //Guardar proceso de editar EC
    $("#btnguardarprocesoECV").click(function(event){
        event.preventDefault();      
        
        var idprocesoec = $('#idprocesoec').val();
        
        if(!validar($('#ddlperiodo'))){     
            mostrarerror($('#ddlperiodo'));}
       else if (!validar($('#txtdescripcion'))){
            mostrarerror($('#txtdescripcion'));}
       else if (!validar($('#busquedaevaluador'))){
           mostrarerror($('#busquedaevaluador'));}
       else if (cantidadcolaboradorestabla()== 0){
           mostrarerror($('#tblcolaboradores'));
       }
       else{
           $('#btnguardarprocesoECV').attr('disabled', 'true');
           $.ajax({
                    type: "POST",
                    url: "../editarprocesoecv/"+idprocesoec,
                    data: obtenerdatoscrearproceso(),
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        $('#btnguardarprocesoEC').removeAttr('disabled');
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
   
   
   //Crear Proceso de EVC
   $("#btncrearprocesoECV").click(function(event){
       event.preventDefault();       
       
       if (!validar($('#ddlpuesto'))){
            mostrarerror($('#ddlpuesto'));}
       else if(!validar($('#ddlperiodo'))){     
            mostrarerror($('#ddlperiodo'));}
       else if (!validar($('#txtdescripcion'))){
            mostrarerror($('#txtdescripcion'));}
       else if (!validar($('#busquedaevaluador'))){
           mostrarerror($('#busquedaevaluador'));}
       else if (cantidadcolaboradorestabla()== 0){
           mostrarerror($('#tblcolaboradores'));
       }
       else{         
       $('#btncrearprocesoECV').attr('disabled', 'true');
       $.ajax({
                    type: "POST",
                    url: "CrearProcesoECV",
                    data: obtenerdatoscrearproceso(),
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        $('#btncrearprocesoEC').removeAttr('disabled');
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
  
    function obtenerdatoscrearpersona(){             
    var data = {};
    data['proceso'] = $.trim($("#txtdescripcion").val());
    data['puesto'] = $("#ddlpuesto").val(); 

    if(cantidadhabilidades() > 0){
        var habilidades = {};
        $("#tblhabilidades > tbody > tr").each(function(index, value) {		
            var habilidad = $(value).find('td:eq(0)').text();	
            var descripcion = $(value).find('td:eq(1)').text();
            var ponderacion = $(value).find('td:eq(2)').text();
            habilidades[habilidad] = {'descripcion' : descripcion, 'ponderacion': ponderacion};
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
       infoponderacion();
   });
   
    $("#btnbusquedacolaboradores").click(function(){       
       limpiarinputshabilidades();
       $("#divcolaborador").show();       
       $("#dialogcolaboradores").dialog('open');
       //infoponderacion();
   });
   

   
   $(document).on("click", "#borrarcolaborador", function(e){
        $(this).parents("tr").remove()       
   });
   
   
   
   $("#btncrearhabilidad").click(function(){         
       
       if(validar($('#txtnombrehabilidad')) && validar($('#txtareadescripcionhabilidad'))&& validar($('#dllponderacion'))){       
        var habilidad = $('#txtnombrehabilidad').val();
        var habilidaddescripcion = $('#txtareadescripcionhabilidad').val();
        var ponderacion = $('#dllponderacion').val(); 
        $('#tblhabilidades > tbody').append('<tr><td name="habilidad">'+habilidad+'</td><td name="descripcion">'+habilidaddescripcion+'</td><td name="ponderacion">'+ponderacion+'</td><td><img id="borrarcolaborador" style="cursor: pointer;" src="../../images/icons/silk/delete.png" alt="Eliminar habilidad"/></td></tr>');               
        if (cantidadhabilidades() >= 5){
            $("#btndialoghabilidadespecial").attr("disabled", "disabled");        
        }       
        $("#dialogHabilidades").dialog('close');
       }else{
           if(!validar($('#txtnombrehabilidad')))
                mostrarerror($('#txtnombrehabilidad'));
           if(!validar($('#txtareadescripcionhabilidad')))
                mostrarerror($('#txtareadescripcionhabilidad'));
           if(!validar($('#dllponderacion')))
                mostrarerror($('#dllponderacion'));
       }
   });
  
  //Validacion de campos
   $('#txtdescripcion').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });
   $('#txtdescripcion').focusin(function(){
        ocultarerror($(this)); 
   });   
   $('#ddlperiodo').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });
   $('#ddlperiodo').focusin(function(){
        ocultarerror($(this)); 
   });
   $('#busquedaevaluador').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });
   $('#busquedaevaluador').focusin(function(){
        ocultarerror($(this)); 
   });
   
   
   function limpiarinputshabilidades(){
       $('#txtnombrehabilidad').val('');
       $('#txtareadescripcionhabilidad').val('');
       $('#dllponderacion').val('');
       ocultarerror($('#txtnombrehabilidad'));
       ocultarerror($('#txtareadescripcionhabilidad'));
       ocultarerror($('#dllponderacion'));
    }
   
   function validar(elemento){
       if($.trim($(elemento).val()) == '' || $(elemento).val()=='-')
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
            callback: function(val){window.location.replace(url);}            
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
    
    
    //Pertenece a la vista agregarpersona
    $("#formagregarpersona").submit(function(event){
       event.preventDefault();   
       
       //if(validar($('#puesto')) && validar($('#colaborador')) && validar($('#tipo'))&& validar($('#id')))
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

                $('#puesto').text('-');                             
                $('#colaborador').val('');                                              
                $('#id').val('');                              
                $('#tipo').val('');                             
                $('#colaborador').removeAttr("disabled");
                $('#btnagregarpersona').attr('disabled', 'true');	
                $("#imgborrar").hide();
                
       }       

            
        });
        
   //Funcionalidad sobre la imagen de borrar en busqueda de evaluador en el proceso de EC
   $("#imgborrarevaluador").on("click",function(){               
        $('#puestoevaluador').text('-');                             
        $('#busquedaevaluador').val('');                                              
        $('#idevaluador').val('');                    
        $('#busquedaevaluador').removeAttr("disabled");
        $("#imgborrarevaluador").hide();
        
        $('#opcionescargacolaborador').css('display', 'none');	
        $('#btnbusquedacolaboradores').css('display', 'none');	
        $('#ddlcargadepartamento').css('display', 'none');	
        
        $('#tblcolaboradores > tbody > tr').remove()
   });
   
   //Funcionalidad sobre la imagen de borrar en busqueda de colaborador en el proceso de EC
   $("#imgborrarcolaborador").on("click",function(){ 
        restablecerbuscarcolaborador();
   });

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
   
   //Validacion cuando se va agregar un colaborador busqueda de colaborador en el proceso de EC
   $("#btnagregarcolaborador").click(function(){         
       
       var idevaluador = $('#idevaluador').val();  
       var cedula = $('#cedulacolaborador').val();
       var idcolaborador = $('#idcolaborador').val(); 
       var puesto = $('#puestocolaborador').text(); 
       var colaborador =  $('#busquedacolaborador').val(); 
       if ($('#indicadoreditar').val() == "true")
           var urlimagenborrarcolaborador = "../../../images/icons/silk/delete.png";
       else
           var urlimagenborrarcolaborador = "../../images/icons/silk/delete.png";
       
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

    function obtenerdatoscrearproceso(){             
    var data = {};    
    data['nombreproceso'] = $.trim($("#txtdescripcion").val());
    data['idevaluador'] = $("#idevaluador").val(); 
    data['periodo'] = $('#ddlperiodo').val();
    data['colaboradores'] = obtenercolaboradoresevaluar();    
    return data;
   }
   
    function obtenercolaboradoresevaluar(){                 
       var colaboradores = Array();
        $("#tblcolaboradores > tbody > tr").each(function(index, fila) {		
            var idcolaborador = $(fila).find('td:eq(0)').text();	            
            colaboradores[index] = idcolaborador;
        });
        return colaboradores;
   }
   
//Dialog Informacion Ponderacion en Habilidades Especiales Dialog

    function infoponderacion(){
    $("#imgponderacionhelp").on("click",function(){            
            infodialog();
        });
    }
    
    function infodialog(){       
         $.ajax({
                    type: "POST",
                    url: 'infoponderacion',                    
                    dataType: 'json',
                    error: function (){                        
                        new Messi('Ha ocurrido un inconveniente al obtener la información.',
                        {title: 'Información', titleClass: 'info', buttons: [{id: 0, label: 'Cerrar', val: 'X'}]});
                    },                        
                    success: function(result){                        
                        new Messi(result.html,
                        {title: 'Información', titleClass: 'info', buttons: [{id: 0, label: 'Cerrar', val: 'X'}]});              
                    }
        });                  
    }
    
    
    function messageconfirmacion(){
        new Messi("This is a message with Messi with custom buttons.", 
        {title: "Buttons", buttons: [{id: 0, label: "Yes", val: true}, {id: 1, label: "No", val: false}], 
            callback: function(val) {                
                   if(val){return true;}
                   else{return false;}         
                }
    });
    }
    
    function borrarprocesoevalucion(url){
//        'ajax'=>array(
//                                            'type'=>'POST',  
//                                            'beforeSend' => 'function(jqXHR, settings){                                               
//                                                            
//                                                            new Messi("This is a message with Messi with custom buttons.", 
//        {title: "Buttons", buttons: [{id: 0, label: "Yes", val: true}, {id: 1, label: "No", val: false}], 
//            callback: function(val) {                
//                    jqXHR.abort();                
//                }
//    });
//                                            }',
//                                            'url'=>"js:$(this).attr('href')", 
//                                            'error' => 'function (jqXHR, textStatus){console.log("ERRO");}',
//                                            'complete' => 'function(){
//                                                            console.log("DONE");
//                                                        }',
//                                           ),
//    }
 }
 
 /*Logica de carga de Colaboradores*/
 
 $("[value='masiva']").on("click",function(){ 
        $('#btnbusquedacolaboradores').css('display', 'none');	
        $('#ddlcargadepartamento').css('display', 'none');
        $('#tblcolaboradores > tbody > tr').remove()
        cargamasivacolaboradores($('#idevaluador').val());        
 });
 
  $("[value='departamento']").on("click",function(){ 
        $('#ddlcargadepartamento').show();
        $('#ddlcargadepartamento').prop('selectedIndex', 0);
        $('#btnbusquedacolaboradores').css('display', 'none');	
        $('#tblcolaboradores > tbody > tr').remove()
 });
 
  $("[value='individual']").on("click",function(){         
        
        $('#btnbusquedacolaboradores').show();
        $('#btnbusquedacolaboradores').removeAttr('disabled');
        $('#ddlcargadepartamento').css('display', 'none');
        $('#tblcolaboradores > tbody > tr').remove()
 });
 
 $('#ddlcargadepartamento').change(function(){               
        $('#tblcolaboradores > tbody > tr').remove()
        var iddepartamento = $('#ddlcargadepartamento').val();
        if(!(iddepartamento == ""))
            cargadepartamentocolaboradores(iddepartamento, $('#idevaluador').val());
 });       
 
    
 function cargamasivacolaboradores(idevaluador){     
      $('#cargaajax').html('<img src="../../images/ajax-loader.gif">');
      
      $.ajax({
                    type: "POST",
                    url: "cargamasiva",                    
                    data: {'idevaluador' : idevaluador},
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        $('#cargaajax > img').remove();
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
                        $('#cargaajax > img').remove();
                        if(datos.value == "error")
                             messagewarning(datos.mensaje);
                        else
                            agregarcolaboradortabla(datos);
                           
                    }
        });
 }
 
 function cargadepartamentocolaboradores (idepartamento, idevaluador){
      $('#cargaajax').html('<img src="../../images/ajax-loader.gif">');
      $.ajax({
                    type: "POST",
                    url: "cargadepartamento",                    
                    data: {'idevaluador' : idevaluador,
                           'iddepartamento' : idepartamento
                          },
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        $('#cargaajax > img').remove();
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
                        $('#cargaajax > img').remove();
                        if(datos.value == "error")
                             messagewarning(datos.mensaje);
                        else
                            agregarcolaboradortabla(datos);
                           
                    }
        });
 }
 
 function agregarcolaboradortabla(arraycolaborador){
    ocultarerror($('#tblcolaboradores'));
    var urlimagenborrarcolaborador = "../../images/icons/silk/delete.png";
    for (var i=0;i<arraycolaborador.length;i++)
    {     
        $('#tblcolaboradores > tbody').append('<tr><td name="idcolaborador" style="display: none">'+arraycolaborador[i].idcolaborador+'</td><td name="cedula">'+arraycolaborador[i].cedula+'</td><td name="colaborador">'+arraycolaborador[i].nombre+'</td><td name="puesto">'+arraycolaborador[i].puesto+'</td><td><img id="borrarcolaborador" style="cursor: pointer; padding-left:5px;" src="'+urlimagenborrarcolaborador+'" alt="Eliminar colaborador"/></td></tr>');    
    }
 }
 
 /*Fin Logica de carga de Colaboradores*/
 
 
 /*PROCESOECV*/
 
//Guardar proceso de editar EC
    $("#btnguardarprocesoECV").click(function(event){
        event.preventDefault();      
        
        
        var idprocesoecv = $('#idprocesoecv').val();
        
        
       if (!validar($('#ddlpuesto'))){
            mostrarerror($('#ddlpuesto'));}
       else if(!validar($('#ddlperiodo'))){     
            mostrarerror($('#ddlperiodo'));}
       else if (!validar($('#txtdescripcion'))){
            mostrarerror($('#txtdescripcion'));}
       else if (!validar($('#fechareclutamiento'))){
            mostrarerror($('#fechareclutamiento'));}
       else if (!validar($('#fechaseleccion'))){
            mostrarerror($('#fechaseleccion'));}
       else if (cantidadpostulantestabla() == 0){
           mostrarerror($('#tblpostulantes'));
       }
       else{
           $('#btnguardarprocesoECV').attr('disabled', 'true');
           $.ajax({
                    type: "POST",
                    url: "../editarprocesoecv/"+idprocesoecv,
                    data: obtenerdatoscrearprocesoECV(),
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        $('#btnguardarprocesoEC').removeAttr('disabled');
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
   
   
   //Crear Proceso de EVC
   $("#btncrearprocesoECV").click(function(event){
       event.preventDefault();       
       
       if (!validar($('#ddlpuesto'))){
            mostrarerror($('#ddlpuesto'));}
       else if(!validar($('#ddlperiodo'))){     
            mostrarerror($('#ddlperiodo'));}
       else if (!validar($('#txtdescripcion'))){
            mostrarerror($('#txtdescripcion'));}
       else if (!validar($('#fechareclutamiento'))){
            mostrarerror($('#fechareclutamiento'));}
       else if (!validar($('#fechaseleccion'))){
            mostrarerror($('#fechaseleccion'));}
       else if (cantidadpostulantestabla() == 0){
           mostrarerror($('#tblpostulantes'));
       }
       else{         
       $('#btncrearprocesoECV').attr('disabled', 'true');
       
       $.ajax({
                    type: "POST",
                    url: "CrearProcesoECV",
                    data: obtenerdatoscrearprocesoECV(),
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        $('#btncrearprocesoECV').removeAttr('disabled');
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
 
 $("#btnagregarpostulante").click(function(){         
       
       $('#ddlpostulanteerror').css('visibility', 'hidden');
       
       var cedula = $('#cedulapostulante');
       var nombre = $('#txtnombrepostulante');   
       var apellido1 = $('#txtapellido1postulante'); 
       var apellido2 = $('#txtapellido2postulante'); 
       if ($('#indicadoreditar').val() == "true")
           var urlimagenborrarcolaborador = "../../../images/icons/silk/delete.png";
       else
           var urlimagenborrarcolaborador = "../../images/icons/silk/delete.png";
       
       
      
      if(!validar(cedula) || isNaN(cedula.val()) ||  !validar(nombre) || !validar(apellido1)  || !validar(apellido2))
        $('#ddlpostulanteerror').css('visibility', 'visible');
      else
      {
      var nombrecompleto = nombre.val()+' '+apellido1.val()+' '+apellido2.val();
      
       if(cantidadcolaboradorestabla()==0){
           $('#tblpostulantes > tbody').append('<tr><td name="id" style="display: none">0</td><td name="cedula">'+cedula.val()+'</td><td name="nombre" style="display: none">'+nombre.val()+'</td><td name="apellido1" style="display: none">'+apellido1.val()+'</td><td name="apellido2" style="display: none">'+apellido2.val()+'</td><td name="nombrecompleto">'+nombrecompleto+'</td><td><img id="borrarcolaborador" style="cursor: pointer; padding-left:5px;" src="'+urlimagenborrarcolaborador+'" alt="Eliminar colaborador"/></td></tr>');     
           $('#ddlpostulantes')
           
       }
       else if (existepostulantestabla(cedula)){
           messageerror('El postulante ya fue agregado.');
       }
       else{
         $('#tblpostulantes > tbody').append('<tr><td name="cedula">'+cedula+'</td><td name="nombre">'+nombrecompleto+'</td><td><img id="borrarcolaborador" style="cursor: pointer; padding-left:5px;" src="'+urlimagenborrarcolaborador+'" alt="Eliminar colaborador"/></td></tr>');     
          $('#ddlpostulanteserror').css('visibility', 'hidden');
       }
       
       restableceragregarpostulante();
       }
       
       ocultarerror($('#tblpostulantes'));
   });
   
 
 
    $("#btnbusquedapostulantes").click(function(){       
       limpiarinputshabilidades();
       $("#divpostulante").show();       
       $("#dialogpostulante").dialog('open');
       //infoponderacion();
   });
 
 function existepostulantestabla(idcomprobar){
       var existe = false;
       $('#tblpostulantes > tbody tr').each(function(index,columna){
           var idpostulante = $(columna).find('td:eq(0)').text();//La columna cero posee el idcolaborador
           if (idcomprobar == idpostulante)
               return existe = true;
       }            
       );
       return existe;           
   }
   
   
   function restableceragregarpostulante(){
        $('#cedulapostulante').val('');                                              
        $('#txtnombrepostulante').val('');       
        $('#txtapellido1postulante').val('');       
        $('#txtapellido2postulante').val('');
   }
   
   function cantidadpostulantestabla(){
      return $('#tblpostulantes > tbody tr').length;       
   }
   
   /*
    $('#fechareclutamiento').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });
   $('#fechareclutamiento').focusin(function(){
        ocultarerror($(this)); 
   });   
   
   
   $('#fechaseleccion').focusin(function(){
        ocultarerror($(this)); 
   });   
    $('#fechaseleccion').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });*/
   
   
   $('#ddlpuesto').focusin(function(){
        ocultarerror($(this)); 
   });
   $('#ddlpuesto').focusout(function(){
       if(!validar($(this)))          
           mostrarerror($(this));     
   });
   
   
   function obtenerdatoscrearprocesoECV(){             
    var data = {};    
    data['puesto'] = $.trim($("#ddlpuesto").val());
    data['fechareclutamiento'] = $.trim($("#fechareclutamiento").val());
    data['fechaseleccion'] = $.trim($("#fechaseleccion").val());
    data['nombreproceso'] = $.trim($("#txtdescripcion").val());
    data['idevaluador'] = $("#idevaluador").val(); 
    data['periodo'] = $('#ddlperiodo').val();
    data['postulantes'] = obtenerpostulantesECV();    
    return data;
   }
   
    function obtenerpostulantesECV(){                 
       var postulantes = Array();
        $("#tblpostulantes > tbody > tr").each(function(index, fila) {		
            var idpostulante = $(fila).find('td:eq(0)').text();
            var cedulapostulante = $(fila).find('td:eq(1)').text();	            
            var nombre = $(fila).find('td:eq(2)').text();
            var apellido1 = $(fila).find('td:eq(3)').text();
            var apellido2 = $(fila).find('td:eq(4)').text();
            postulantes[index] = new Array(cedulapostulante, nombre, apellido1, apellido2, idpostulante);
            
        });
        return postulantes;
   }
   
    
 
});
