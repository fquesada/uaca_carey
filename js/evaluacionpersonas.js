$(document).ready(function() {
    
   //Proceso crear evaluacion persona
   $("#btncrearevaluacionpersona").click(function(event){
       event.preventDefault();
       
   });  
   
   //Gestion dialog habilidades especiales
   $("#btndialoghabilidadespecial").click(function(){            
       $("#divhabilidad").show();
       $("#dialogHabilidades").dialog('open');
   });
   
   $("#borrarhabilidad").css( "cursor", "pointer");
   
   $(document).on("click", "#borrarhabilidad", function(e){
        $(this).parents("tr").remove()
        if (limitehabilidades() < 5){
           $("#btndialoghabilidadespecial").removeAttr('disabled');        
        }
   });
   
   $("#btncrearhabilidad").click(function(){         
       var habilidad = $('#txtnombrehabilidad').val();
       var habilidaddescripcion = $('#txtareadescripcionhabilidad').val();       
       $('#txtnombrehabilidad').val('');
       $('#txtareadescripcionhabilidad').val('');       
       $('#tblhabilidades > tbody').append('<tr><td>'+habilidad+'</td><td>'+habilidaddescripcion+'</td><td><img id="borrarhabilidad" style="cursor: pointer;" src="../../images/icons/silk/delete.png" alt="Eliminar habilidad"/></td></tr>');               
       if (limitehabilidades() >= 5){
           $("#btndialoghabilidadespecial").attr("disabled", "disabled");        
       }       
       $("#dialogHabilidades").dialog('close');       
   });
   
   function limitehabilidades(){
      return $('#tblhabilidades > tbody tr').length;       
   }  
      
});

