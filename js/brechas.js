$(document).ready(function() {

    //Metodo para Cargar Historico Evaluaciones
    window.cargarHistoricoEvaluaciones = function (idcolaborador) {        
        $('#tblEvaluaciones > tbody').html('');
        $('#divColaborador').css('display', 'none');
        $('#divEvaluaciones').css('display', 'none');
        $('#divNoEvaluaciones').css('display', 'none');
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
                $('#divCargando').css('display', 'none');                
                if(datos.resultado){                    
                    $('#divColaborador').show();
                    $('#divEvaluaciones').show();
                    mostrarDatosColaborador(datos.colaborador);
                    mostrarEvaluaciones(datos.evaluaciones, true);                    
                }else{                    
                    $('#divNoEvaluaciones').show();
                    mostrarEvaluaciones(datos.evaluaciones, false);
                }
            }
        });
    }
    
    function mostrarDatosColaborador(colaborador){
        $('#spColaborador').html(colaborador.nombrecompleto);
        $('#spCedula').html(colaborador.cedula);
        $('#spPuesto').html(colaborador.puestoactual);
        $('#spDepartamento').html(colaborador.unidadnegocioactual);
        $('#spEstado').html(colaborador.estadocolaborador);
    }
    
    function mostrarEvaluaciones(evaluaciones, indicadorevaluacion){
        if(indicadorevaluacion){
            var index;        
            for (index = 0; index < evaluaciones.length; ++index) {
                var puesto = evaluaciones[index].Puesto;
                var departamento = evaluaciones[index].UnidadNegocio;
                var tipoevaluacion = evaluaciones[index].TipoEvaluacion;
                var evaluador = evaluaciones[index].Evaluador;           
                var calificacion = evaluaciones[index].Calificacion;
                var idevaluacion = evaluaciones[index].IDEvaluacion;
                var fechaevaluacion = evaluaciones[index].FechaEvaluacion;
                $('#tblEvaluaciones > tbody').append('<tr><td id="tdIdEvalacion">'+idevaluacion+'</td><td>'+departamento+'</td><td>'+puesto+'</td><td id="tdTipoProceso">'+tipoevaluacion+'</td><td>'+fechaevaluacion+'</td><td>'+evaluador+'</td><td>'+calificacion+'</td><td><img src="../../images/icons/silk/chart_pie.png" class="imgReporte" id="imgReporte"></img></td></tr>');
            }
        }
        else{
            $('#divNoEvaluaciones').html(evaluaciones);
        }
    }
    
    $(document).on("click", "#imgReporte", function(event){
        event.preventDefault();
        var idEvaluacion = $(this).parents("tr").find('#tdIdEvalacion').text();
        var tipoProceso = $(this).parents("tr").find('#tdTipoProceso').text();
        $.ajax({
                    type: "POST",
                    url: "GenerarReporte",
                    data: {id: idEvaluacion, tipo: tipoProceso},
                    dataType: 'json',
                    error: function (jqXHR, textStatus){
                        messagewarning("Ha ocurrido un inconveniente, intente nuevamente. (Codigo Sistema:"+ jqXHR.status + ")");                                  
                    },
                    success: function(datos){
                        window.location.replace(datos.url);
                    }
        })
   });

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