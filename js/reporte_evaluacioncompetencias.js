document.observe('dom:loaded', function(){

var parametros = { idevaluacionpersonas : document.getElementById('lblidpersonas').innerHTML,
             idevaluacioncompetencias: document.getElementById('lblidcompetencia').innerHTML};

new Ajax.Request('DataReporteEvaluacionCompetencias', {
  method:'post',
  parameters: parametros,
  onSuccess: function(transport) {
     var json = transport.responseText.evalJSON(true);
     //Radar
     var arrayticks = json[0];
     var arrays1 = json[1];
     var arrays2 = json[2];
     var ticks = arrayticks.labels;
     var s1 = arrays1.ideal;
     var s2 = arrays2.evaluacion; 
     
     //Bar Relativo
     var barlabelsrelativo = json[3];
     var barserierelativo = json[4];
     
     //Bar Ideal y Calificado
     var barlabelsideal = json[5];
     var barserieideal = json[6];     
     var barseriecalificado = json[7];
     
    //Grafico de Valoracion Relativa
    Flotr.draw($('contentValoracionRelativa'),[barserierelativo],
    {
      colors: ['#cb4b4b'],
      title: "Valoracion Relativa",
      grid:{outlineWidth : 2, horizontalLines : false, verticalLines : true, labelMargin : 5},
      bars:{show : true, horizontal : true, shadowSize : 0, barWidth : 0.9, fillOpacity: 1},     
      xaxis:{min : 0, autoscaleMargin : 4, title: "Ponderacion"},
      yaxis:{ticks : barlabelsrelativo}
    });
    
    //Grafico de Comparacion de Competencias
    Flotr.draw($('contentComparacionCompetencias'),[barserieideal,barseriecalificado],
    {
      title: "Comparacion de Competencias",
      grid:{outlineWidth : 2, horizontalLines : false, verticalLines : true, labelMargin : 5},
      bars:{show : true, horizontal : true, shadowSize : 0, barWidth : 0.4, fillOpacity: 1},     
      xaxis:{min : 0, autoscaleMargin : 4, title: "Calificacion"},
      yaxis:{ticks : barlabelsideal}      
    });
    
    //Grafico de Cobertura de Requisitos    
    Flotr.draw($('contentCoberturaRequisitos'), [ s1, s2 ], {        
        title: "Analisis de Cobertura de Requisitos",
        radar : { show : true}, 
        grid  : { circular : true, minorHorizontalLines : true}, 
        yaxis : { min : 0},     
        xaxis : { ticks : ticks},
        legend : { position: "nw"}
    });
    
  },//onSuccess
  onFailure: function() {      
      $('contentValoracionRelativa').update('Ha ocurrido un error obteniendo el grafico');
  }
});

});

