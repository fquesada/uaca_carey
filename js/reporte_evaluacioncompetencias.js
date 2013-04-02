document.observe('dom:loaded', function(){

var parametros = { idevaluacionpersonas : document.getElementById('lblidpersonas').innerHTML,
             idevaluacioncompetencias: document.getElementById('lblidcompetencia').innerHTML};

new Ajax.Request('DataReporteEvaluacionCompetencias', {
  method:'post',
  parameters: parametros,
  onSuccess: function(transport) {
     var json = transport.responseText.evalJSON(true);
     var arrayticks = json[0];
     var arrays1 = json[1];
     var arrays2 = json[2];
     
     var ticks = arrayticks.labels;
     var s1 = arrays1.ideal;
     var s2 = arrays2.evaluacion;
     
     
     graph = Flotr.draw($('contentCoberturaRequisitos'), [ s1, s2 ], {
        radar : { show : true}, 
        grid  : { circular : true, minorHorizontalLines : true}, 
        yaxis : { min : 0, max : 5, minorTickFreq : 2}, 
        xaxis : { ticks : ticks},
        legend : { position: "ne"}
      });
    
  },
  onFailure: function() {      
      $('contentCoberturaRequisitos').update('Ha ocurrido un error obteniendo el grafico');
  }
});

});

