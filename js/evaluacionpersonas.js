$(document).ready(function() {
    
   //Proceso crear evaluacion persona
   $("#btncrearevaluacionpersona").click(function(event){
       event.preventDefault();
       $.ajax({
                    type: "POST",
                    url: "Crear",
                    data: obtenerdatoscrearpersona(),
                    dataType: 'json',
                    success: function(result) {                       
                        if(result.ok){                          
                       
                        }				
                    }
        });       
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
       $("#divhabilidad").show();
       $("#dialogHabilidades").dialog('open');
   });
   
   $("#borrarhabilidad").css( "cursor", "pointer");
   
   $(document).on("click", "#borrarhabilidad", function(e){
        $(this).parents("tr").remove()
        if (cantidadhabilidades() < 5){
           $("#btndialoghabilidadespecial").removeAttr('disabled');        
        }
   });
   
   $("#btncrearhabilidad").click(function(){         
       var habilidad = $('#txtnombrehabilidad').val();
       var habilidaddescripcion = $('#txtareadescripcionhabilidad').val();       
       $('#txtnombrehabilidad').val('');
       $('#txtareadescripcionhabilidad').val('');       
       $('#tblhabilidades > tbody').append('<tr><td name="habilidad">'+habilidad+'</td><td name="descripcion">'+habilidaddescripcion+'</td><td><img id="borrarhabilidad" style="cursor: pointer;" src="../../images/icons/silk/delete.png" alt="Eliminar habilidad"/></td></tr>');               
       if (cantidadhabilidades() >= 5){
           $("#btndialoghabilidadespecial").attr("disabled", "disabled");        
       }       
       $("#dialogHabilidades").dialog('close');       
   });
   
   function cantidadhabilidades(){
      return $('#tblhabilidades > tbody tr').length;       
   }  
      
});

