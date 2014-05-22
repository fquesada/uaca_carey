$(document).ready(function() {
        
    //Validaciones
    $('#ddlperiodo').change(function(){                    
           $(this).siblings(".errorcalificacion").remove();
           var periodo = $(this).val();
           if(periodo == '')
               $(this).parent().append('<div class="errorcalificacion">Seleccione un período.</div>'); 
    });
    
    $('#tblpuntualizaciones > tbody > tr > td > textarea').each(function(){
            $(this).on('blur', function(){
                $(this).siblings(".errorcalificacion").remove();
                var periodo = $(this).val();
                if(periodo == '')
                     $(this).parent().append('<div class="errorcalificacion">Ingrese un compromiso.</div>');                
            });   
            
            $(this).on('focusin', function(){
             $(this).siblings(".errorcalificacion").remove();
            });
    });           
});


