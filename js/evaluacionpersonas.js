$(document).ready(function() {
    
    $('#btnmessi').click(function(event){
       new Messi('responsejax.v', 
                            {   title: 'Éxito.', 
                                titleClass: 'success',                                 
                                modal:true,
                                closeButton: false,
                                buttons: [{id: 0, label: 'Cerrar', val: 'X'}],
                                callback: function(val){var url = "admin/";    
                                                        $(location).attr('href',url);}
                            });
       
    });
    
    
   //Proceso crear evaluacion persona
   $("#btncrearevaluacionpersona").click(function(event){
       event.preventDefault();
       
      if(validar($('#txtdescripcion')) && validar($('#ddlpuesto'))){       
       $.ajax({
                    type: "POST",
                    url: "Crear",
                    data: obtenerdatoscrearpersona(),
                    dataType: 'json',
                    success: function(data) {
                    if(data.r){
                        alert("hola");
                    }
                    else{
                       alert("hola");
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
       if($(elemento).val() == '')
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
});

