$(document).ready(function() {   
        $('#tblcompromisos > tbody > tr > td > select').each(function(){
            $(this).on('change', function(){
                var data_compromisos = {
                action: 'procesarevacompromisos',
                evaid: $(this).attr("id"),
//                eva: $(this).val()    
                eva : $('option:selected', this).text()
                };
                $.ajax({
                    type: "POST",
                    url: "ProcesarEvaluacionCompromisos",
                    data: data_compromisos,
                    dataType: 'json',
                    success: function(result) {
                        establecercolorrango(result.valortotal);
                        if(result.ok){                           
                            $('#compromisoprom').text(result.valor);
                            $('#compromisosnivel').text(result.valor); 
                            $('#evaluacion').text(result.valortotal);
                            $('#'+result.id).siblings(".errorcalificacion").remove();
                        }
                        else{
                             $('#compromisoprom').text(result.valor);
                             $('#compromisosnivel').text(result.valor);
                             $('#evaluacion').text(result.valortotal);
                             $('#'+result.id).parent().append('<div class="errorcalificacion">'+ result.msg +'</div>');
                        }				
                    }
                });
            });
        });
        
        $('#tblcompetencias > tbody > tr > td > select').each(function(){                        
            $(this).on('change', function(){
                var data_compromisos = {
                action: 'procesarevacompetencias',
                evaid: $(this).attr("id"),
//                eva: $(this).val()       
                eva : $('option:selected', this).text()
                };
                $.ajax({
                    type: "POST",
                    url: "ProcesarEvaluacionCompetencias",
                    data: data_compromisos,
                    dataType: 'json',
                    success: function(result) {
                        establecercolorrango(result.valortotal);
                        if(result.ok){                           
                            $('#competenciaprom').text(result.valor);
                            $('#competenciasnivel').text(result.valor);
                            $('#evaluacion').text(result.valortotal);                            
                            $('#'+result.id).siblings(".errorcalificacion").remove();
                        }
                        else{
                             $('#competenciaprom').text(result.valor);
                             $('#competenciasnivel').text(result.valor);
                             $('#evaluacion').text(result.valortotal);
                             $('#'+result.id).parent().append('<div class="errorcalificacion">'+ result.msg +'</div>');
                        }				
                    }
                });
            });            
        });
        
        
        
        function establecercolorrango(valorfinal) {
            var superior = 5;
            var sobresaliente = 4;
            var esperado = 3;
            var mejora = 2 
            
            $('.table_evaluacion_resultado').css('margin', '0 50px 0 8%');//Conservar la posicion de las tablas                         
            $('#rango').removeClass(); 
            $('#rango').empty();
            
            if(parseFloat(valorfinal) == superior){
                $('#rango').addClass('superior');                
                $('#rango').html($('#superior').html());
            }else if (parseFloat(valorfinal) >= sobresaliente){
                $('#rango').addClass('sobresaliente');                
                $('#rango').html($('#sobresaliente').html());
            }else if (parseFloat(valorfinal) >=  esperado){
                $('#rango').addClass('esperado');                
                $('#rango').html($('#esperado').html());
            }else if (parseFloat(valorfinal) >= mejora){
                $('#rango').addClass('mejora');                
                $('#rango').html($('#mejora').html());
            }else{
                $('#rango').addClass('insuficiente');                
                $('#rango').html($('#insuficiente').html());
            }
       }
       
       $('input, textarea').placeholder();
       
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


