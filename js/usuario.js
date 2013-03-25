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
});