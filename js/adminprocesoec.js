$(document).ready(function() {

    $(document).on("click", "#imgenviarcorreo", function(event){
        
        event.preventDefault();        
        $("#contenidoenlaceindividual").html(
            "Nombre: "+ $(this).parents("tr").find('th:eq(2)').text()+"<br/>"+          
            "Cédula: "+ $(this).parents("tr").find('th:eq(1)').text()+"<br/>"+
            "Puesto: "+ $(this).parents("tr").find('th:eq(3)').text()+"<br/>"+
            "<a href="+$(this).parents("tr").find('th:eq(6)').find('a:first').attr("href")+">Click para ir a la evaluación</a>"+
            "<hr>"
            );
        $("#divenlacesinvidual").show();       
        $("#dialogenlacesinvidual").dialog('open');
    });

    $(document).on("click", "#imggenerarreporte", function(event){
        event.preventDefault();
        var idec = $(this).parents("tr").find('#idec').text();                
        $.ajax({
            type: "POST",
            url: "../crearreporteec",
            data: {
                id: idec
            },
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
    
    $("#verenlaces").click(function(){ 
        $("#divenlaces").show();       
        $("#dialogenlaces").dialog('open');
    }); 
});
   
