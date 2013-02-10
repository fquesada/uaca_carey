
<div class="content_section_evaluacion">
        <h2>Evaluacion de Competencias</h2>
        <h4>Escala de evaluacion</h4>
        <?php
                echo $this->obtenercompetenciasevaluar($model->puesto);
        ?>
</div> 


<?php if(Yii::app()->user->hasFlash('error')):?>
    <div>
        <script type="text/javascript"> alert('<?php echo Yii::app()->user->getFlash('error'); ?>');
                 var url = "../";    
                 $(location).attr('href',url);
        </script>
    </div>
<?php endif; ?>