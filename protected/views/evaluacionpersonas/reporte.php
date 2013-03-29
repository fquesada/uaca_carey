<?php echo $this->renderPartial('_reporteencabezado', array('evaluacioncompetencias'=>$evaluacioncompetencias)); ?>


<h4 style="text-align: center">Calificacion de Competencias</h4>
<?php
echo "<p>Calificacion</p>";
echo "<br/>";
print_r($datacalificacion);
echo "<br/>";
echo "<br/>";
echo "<p>Relativo</p>";
print_r($datarelativo);
echo "<br/>";
echo "<br/>";
echo "<p>Ideal</p>";
print_r($dataideal);
?>

<script type="text/javascript">
    dojoConfig = {
	async: true,
        parseOnLoad: false, //enables declarative chart creation
        gfxRenderer: "svg,silverlight,vml" // svg is first priority                
    };
</script>

<!--	 load Dojo -->
<script type="text/javascript" src="../../js/dojo/dojo.js"></script>	   
	
<script type="text/javascript">
require(["dojo/request/xhr", "dojo/dom", "dojo/dom-construct", "dojo/json", "dojo/domReady!"],
function(xhr, dom, domConst, JSON){  
    xhr("getjson",{
      query: {
        idevaluacionpersonas: 29,
        idevaluacioncompetencias: 1
      },     
      handleAs: "json"
      }).then(function(data){
      domConst.place("<p>response: <code>" + JSON.stringify(data) + "</code></p>", "output");
    }, function(err){
      domConst.place("<p>error: <p>" + err.response.text + "</p></p>", "output");  
  });
});</script>

<script type="text/javascript" >
        require([
        // Require the basic 2d chart resource
        "dojox/charting/Chart", 	
        // Require the theme of our choosing
        "dojox/charting/themes/Wetland",		      	
	//Tipo de chart
	"dojox/charting/plot2d/Spider",
        "dojo/request/xhr","dojo/domReady!"	
	], function(Chart, theme, Spider, xhr){
            
                //Assume you have a div with id as "chart1" to show your chart
		var chart = new Chart("analisiscoberturarequisitos"); //Chart2D is a subclass of Chart	
		chart.setTheme(theme); //many different themes with different color combinations
		chart.addPlot("default", { 
		type : Spider,                  
		labelOffset : -10,
		//divisions : 12,                // number of axises
		seriesFillAlpha : .2,            // transparency of the color overlay
		markerSize : 3,                  // size of the circular marker
		precision : 0,                   
		spiderType : "polygon",          // style of background grid. can be "circle" also.
		htmlLabels: true                // use html to draw labels		
		});           
                
                    xhr("getjson",{
                    query: {
                      idevaluacionpersonas: 29,
                      idevaluacioncompetencias: 1
                    },     
                    handleAs: "json"
                    }).then(function(data){
                        chart.addSeries("Time1",{ 
                            data : data[0]
                            }, {
                            fill : "blue"
                    });
                    chart.addSeries("Time2",{ 
                            data : data[1]
                            }, {
                            fill : "green"
                    });
                    chart.render(); //draw the spider chart
                    }, function(err){
                    //Do something 
                    });
		});
	</script>
     
<h1>Output:</h1>
<div id="output"></div>
<button type="button" id="startButton">Start</button>


	<!-- create the chart -->
<div id="analisiscoberturarequisitos"></div>	

<div id="licenseContainerPreventCache"></div>

