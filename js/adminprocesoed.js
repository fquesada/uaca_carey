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
   
   
   $(document).on("click", "#imgregistrarcompromisos", function(event){        
        event.preventDefault();        
        $("#contenidocompromisosindividual").html(
            "Nombre: "+ $(this).parents("tr").find('th:eq(2)').text()+"<br/>"+          
            "Cédula: "+ $(this).parents("tr").find('th:eq(1)').text()+"<br/>"+
            "Puesto: "+ $(this).parents("tr").find('th:eq(3)').text()+"<br/>"+
            "<a href="+$(this).parents("tr").find('th:eq(9)').find('a:first').attr("href")+">Click para ir a la evaluación</a>"+
            "<hr>"
            );
        $("#divenlacescompromisosinvidual").show();       
        $("#dialogenlacescompromisosinvidual").dialog('open');
    });
    
    $(document).on("click", "#imgregistrarevaluacion", function(event){        
        event.preventDefault();        
        $("#contenidodesempenoindividual").html(
            "Nombre: "+ $(this).parents("tr").find('th:eq(2)').text()+"<br/>"+          
            "Cédula: "+ $(this).parents("tr").find('th:eq(1)').text()+"<br/>"+
            "Puesto: "+ $(this).parents("tr").find('th:eq(3)').text()+"<br/>"+
            "<a href="+$(this).parents("tr").find('th:eq(9)').find('a:last').attr("href")+">Click para ir a la evaluación</a>"+
            "<hr>"
            );
        $("#divenlacesdesempenoinvidual").show();       
        $("#dialogenlacesdesempenoinvidual").dialog('open');
    });

    function messagewarning(message){
        new Messi(message,
        {   
            title: 'Advertencia', 
            titleClass: 'anim warning',                                 
            modal:true
        });
    }
    
    $("#verenlacescompromisos").click(function(){ 
        $("#divenlacescompromisos").show();       
        $("#dialogenlacescompromisos").dialog('open');
    }); 
    
    $("#verenlacesdesempeno").click(function(){ 
        $("#divenlacesdesempeno").show();       
        $("#dialogenlacesdesempeno").dialog('open');
    });
    
    
    
   });