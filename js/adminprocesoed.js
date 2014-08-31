$(document).ready(function() {

$(document).on("click", "#imggenerarreporte", function(event){
        event.preventDefault();
        var ided = $(this).parents("tr").find('#ided').text();                
        $.ajax({
                    type: "POST",
                    url: "../CrearReporteED",
                    data: {id: ided},
                    dataType: 'json',
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
                    success: function(datos){
                        window.location.replace(datos.url);
                    }
        })
   });

   function messageerror(message){
        new Messi(message,
        {   
            title: 'Alerta', 
            titleClass: 'anim error',                                 
            modal:true                                          
        });
    }
   
   });