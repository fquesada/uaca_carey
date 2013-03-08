$(document).ready(function() {
   $("#btncrearevaluacionpersona").click(function(){            
       $("#divhabilidad").show();
       $("#dialogHabilidades").dialog('open');
   });
   
   $("#btncrearhabilidad").click(function(){  
       
       var habilidad = $('#txtnombrehabilidad').val();
       var habilidaddescripcion = $('#txtareadescripcionhabilidad').val();      
       
       $('#txtnombrehabilidad').val('');
       $('#txtareadescripcionhabilidad').val('');
       
       $('#tblhabilidades > tbody').append('<tr><td>'+habilidad+'</td><td>'+habilidaddescripcion+'</td><td><img src="../../images/icons/silk/delete.png" alt="Eliminar habilidad"/></td></tr>');       
       
       if (limitehabilidades() >= 5){
           $("#btncrearevaluacionpersona").attr("disabled", "disabled");        
       }
       
       $("#dialogHabilidades").dialog('close');
       
   });
   
   function limitehabilidades(){
       var numerohabilidades = $('#tblhabilidades > tbody tr').length;     
       return numerohabilidades;
   }
   
   $('#tblhabilidades > tbody > tr > td > img').click(function(){  
       alert('hola');
   });
   
});

