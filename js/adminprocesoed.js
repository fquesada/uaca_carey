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
                        messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");                                  
                    },
                    success: function(datos){
                        window.location.replace(datos.url);
                    }
        })
   });


$(document).on("click", "#imgvercompromisos", function(event){
        event.preventDefault();
        var ided = $(this).parents("tr").find('#ided').text();                
        $.ajax({
                    type: "POST",
                    url: "../CrearReporteCompromisos",
                    data: {id: ided},
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");                                  
                    },
                    success: function(datos){
                        window.location.replace(datos.url);
                    }
        })
   });

    function messagewarning(message){
        new Messi(message,
        {   
            title: 'Advertencia', 
            titleClass: 'anim warning',                                 
            modal:true
        });
    }
   });