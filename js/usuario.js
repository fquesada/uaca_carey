$(document).ready(function(){  
  $('#divcolaborador').hide();
  
  $('#Usuario_confirmacion').click(function() {
      var checkbox = $(this);
        if (checkbox.is (':checked')){
            $('#colaborador').val('')
            $('#divcolaborador').show();
        }else{            
        $('#divcolaborador').hide();
        }
    });
    
    $("#imgcolaboradorhelp").on("click",function(){
        infodialog();
    });
    
    function infodialog(){
        new Messi("Esta opción le habilita el acceso a un colaborador al sistema, permitiendole así evaluar a sus subordinados.",
        {title: 'Información', titleClass: 'info', buttons: [{id: 0, label: 'Cerrar', val: 'X'}]});          
    }
});