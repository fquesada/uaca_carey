$(document).ready(function() {

    //Metodo para Cargar Historico Evaluaciones
    window.cargarHistoricoEvaluaciones = function (idcolaborador) {
        $('#divCargando').show();
        
        $.ajax({
            type: "POST",
            url: "CargarHistoricoEvaluaciones",
            data: {
                id : idcolaborador
            },
            dataType: 'json',
            timeout: 120000, 
            error: function (jqXHR, textStatus){                    
                $('#divCargando').css('display', 'none');	
                messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");                                    
            },
            success: function(datos){                          
                if(datos.resultado){
                    $('#divCargando').css('display', 'none');
                    alert(datos.colaborador);
                }else{
                    $('#divCargando').css('display', 'none');
                    alert(datos.evaluaciones);}
            }
        });
    }

    //MENSAJES
    function messagewarning(message){
        new Messi(message,
        {   
            title: 'Advertencia', 
            titleClass: 'anim warning',                                 
            modal:true
        });
    }

});