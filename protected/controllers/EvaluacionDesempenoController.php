<?php

class EvaluacionDesempenoController extends RController
{
    const ZERO = 0;
    const STRING_NULL = '';
    const PORCENTAJECOMPROMISOS = 0.80;
    const PORCENTAJECOMPETENCIAS = 0.20;
        
    public function filters(){
        return array(
            'rights',
        );
    }
    
    public function allowedActions()
    {
        return 'index, ProcesarEvaluacionCompromisos, ProcesarEvaluacionCompetencias';
    }
    
    public function actionIndex(){        
              
            $dataProvider = new CActiveDataProvider('Evaluaciondesempeno',array('data'=>array()));// Evaluacion::model()->findAll();//ByAttributes(array('colaborador'=>2));
           if (Yii::app()->request->isAjaxRequest) 
            {
               $colaborador = $_GET['idcolaborador'];
               $dataProvider =new CActiveDataProvider('Evaluaciondesempeno',array('criteria'=>array(
                  'condition'=>'colaborador='.$colaborador)));                                
               $this->renderPartial('index',array('dataProvider'=>$dataProvider));
            }                           
            else
            {                            
		$this->render('index',array('dataProvider'=>$dataProvider));
            }
	}
        
    public function actionAutoCompleteColaborador()
        {
            if (isset($_GET['term'])) {

                $keyword=$_GET['term'];
                // escape % and _ characters
                $keyword=strtr($keyword, array('%'=>'\%', '_'=>'\_'));
                               
                $dataReader = Yii::app()->db->createCommand(
                        'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2,p.nombre as puesto,u.nombre as unidad, c.id '.
                        'FROM colaborador c '.
                        'JOIN puesto p ON c.puesto = p.id '.
                        'JOIN unidadnegocio u ON c.unidadnegocio = u.id '.
                        'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%'.$keyword.'%" AND c.estado = 1;'
                        )->query();                               
                
                /*->select(array('c.cedula','c.nombre','c.apellido1','c.apellido2','p.nombre as puesto','u.nombre as unidad', 'c.id'))
                ->from('colaborador c')
                ->join('puesto p', 'c.puesto=p.id')                  
                ->join('unidadnegocio u', 'u.id=c.unidadnegocio')
                ->where(array('like', 'CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 )','%'.$keyword.'%'))                
                ->limit(10)*/
                                

                $return_array = array();
                if($dataReader->count() == 0)
                {
                    $return_array[] = array(
                    'label'=>'No hay resultados.',
                    'value'=>'', 
                    );
                }
                else{ 
                    foreach($dataReader as $row){ 
                        $nombrecompleto = $row['nombre'].' '.$row['apellido1'].' '.$row['apellido2'];
                        $return_array[] = array(
                        'label'=>'<div style="font-size:x-small"> céd: '.$row['cedula'].'</div>'.'<div>'.$nombrecompleto.'</div><hr>',
                        'value'=>$nombrecompleto, 
                        'id'=>$row['id'],
                         'cedula'=>$row['cedula'],
                        'puesto'=>$row['puesto'],
                        'unidad'=>$row['unidad'],
                        );
                    }
                }
                
                echo CJSON::encode($return_array);               
            }
        }
    
    //actions
    
    public function actionCompromisos(){
        
            //En caso de submit
            if(isset($_POST['puntualizacion'])&& isset($_POST['periodo'])&& isset($_POST['fechaevaluacion'])){                        
                $valoresevaluacion = $_SESSION['dataevaluacion'];
                $evaluacion = new EvaluacionDesempeno();
                $evaluacion->evaluador = $valoresevaluacion['idevaluador'];
                $evaluacion->fecharegistrocompromiso = $this->fechaphptomysql(date('d-m-Y'));//Agregar horas minutos segundos
                $evaluacion->fechaevaluacion = $this->fechaphptomysql($_POST['fechaevaluacion']);
                $evaluacion->colaborador = $valoresevaluacion['idcolaborador'];
                $evaluacion->comentariocompromisos = trim($_POST['comentario']);
                $evaluacion->puesto = $valoresevaluacion['idpuesto'];
                $evaluacion->periodo = $_POST['periodo'];


                $compromisos = array();                
                foreach ($_POST['puntualizacion'] as $id => $value) {
                    $compromisos[] = array(
                        'idpuntualizacion' => $id,
                        'compromiso' => $value,
                    );                            
                }

                $transaction = Yii::app()->db->beginTransaction();                       

                $result = $evaluacion->save();                        
                $idevaluacion = $evaluacion->id;

                if($result){                        
                    foreach($compromisos as $compromiso)
                    {
                        $nuevocompromiso = new Compromiso;
                        $nuevocompromiso->evaluacion = $idevaluacion;
                        $nuevocompromiso->puntualizacion = $compromiso['idpuntualizacion'];
                        $nuevocompromiso->compromiso = $compromiso['compromiso'];
                        $result = $nuevocompromiso->save();
                    }
                    if($result)
                    {                                
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Se ha ingresado correctamente los compromisos del colaborador '.$valoresevaluacion['nombrecolaborador'].'.');                                                       
                    }
                    else{
                        $transaction->rollBack();                  
                         Yii::app()->user->setFlash('warning', 'Ha ocurrido un inconveniente al intentar guardar los compromisos del colaborador '.$valoresevaluacion['nombrecolaborador'].'.');                             
                    }
                }
                else{
                    $transaction->rollBack();                  
                      Yii::app()->user->setFlash('warning', 'Ha ocurrido un inconveniente al intentar guardar los compromisos del colaborador '.$valoresevaluacion['nombrecolaborador'].'.');                          
                }               
            }

            $idusuario = Yii::app()->user->id;
            $usuario = Usuario::model()->findByPk($idusuario);
            $evaluadorarray = $usuario->_evaluador;  
            
            if($evaluadorarray===null)
                    throw new CHttpException(500,'La peticion solicitado no puede realizarse.');            
            $evaluador = $evaluadorarray[0];
            
            if(!isset($_POST['idcol'])){
                $this->redirect('index');
            }
            
            $idcolaborador = $_POST['idcol'];
            $colaborador = Colaborador::model()->findByPk($idcolaborador);            
            
            if($colaborador===null)
                    throw new CHttpException(500,'La peticion solicitado no puede realizarse.');

            $sessioneva['idevaluador'] = $evaluador->id;
            $sessioneva['nombreevaluador'] = $evaluador->obtenernombrecompleto();
            $sessioneva['idcolaborador'] = $colaborador->id;
            $sessioneva['nombrecolaborador'] = $colaborador->obtenernombrecompleto();
            
            
            $idpuesto = $colaborador->_puesto->puesto;
            $puesto = Puesto::model()->findByPk($idpuesto);
            
            $sessioneva['idpuesto'] = $puesto->id;
            $sessioneva['nombrepuesto'] = $puesto->nombre;

            //Guardamos la informacion en una session para utilizarla en CrearNuevoCompromisos                
            $_SESSION['dataevaluacion'] = $sessioneva;  

            $this->render('nuevoscompromisos',array(
                    'model'=>$sessioneva,
            ));             
    }
    
    public function actionCrearNuevoCompromisos(){

            if(isset($_POST['puntualizacion'])&& isset($_POST['periodo'])&& isset($_POST['fechaevaluacion'])){                        
                    $valoresevaluacion = $_SESSION['dataevaluacion'];
                    $evaluacion = new Evaluacion();
                    $evaluacion->evaluador = $valoresevaluacion['idevaluador'];
                    $evaluacion->fecharegistrocompromiso = $this->fechaphptomysql(date('d-m-Y'));
                    $evaluacion->fechaevaluacion = $this->fechaphptomysql($_POST['fechaevaluacion']);
                    $evaluacion->colaborador = $valoresevaluacion['idcolaborador'];
                    $evaluacion->comentariocompromisos = trim($_POST['comentario']);
                    $evaluacion->puesto = $valoresevaluacion['idpuesto'];
                    $evaluacion->periodo = $_POST['periodo'];


                    $compromisos = array();                
                    foreach ($_POST['puntualizacion'] as $id => $value) {
                        $compromisos[] = array(
                            'idpuntualizacion' => $id,
                            'compromiso' => $value,
                        );                            
                    }

                    $transaction = Yii::app()->db->beginTransaction();                       

                    $result = $evaluacion->save();                        
                    $idevaluacion = $evaluacion->id;

                    if($result){                        
                        foreach($compromisos as $compromiso)
                        {
                            $nuevocompromiso = new Compromiso;
                            $nuevocompromiso->evaluacion = $idevaluacion;
                            $nuevocompromiso->puntualizacion = $compromiso['idpuntualizacion'];
                            $nuevocompromiso->compromiso = $compromiso['compromiso'];
                            $result = $nuevocompromiso->save();
                        }
                        if($result)
                        {                                
                            $transaction->commit();
                            Yii::app()->user->setFlash('exito', 'Se ha ingresado correctamente los compromisos del colaborador '.$valoresevaluacion['nombrecolaborador']);
                            $this->redirect(array('view','id'=>$evaluacion->id));
                        }
                        else{
                            $transaction->rollBack();                  
                             Yii::app()->user->setFlash('warning', 'Lo sentimos, ha ocurrido un problema al intentar guardar los compromisos del colaborador '.$valoresevaluacion['nombrecolaborador']);
                        }
                    }
                    else{
                        $transaction->rollBack();                  
                          Yii::app()->user->setFlash('warning', 'Lo sentimos, ha ocurrido un problema al intentar guardar los compromisos del colaborador '.$valoresevaluacion['nombrecolaborador']);
                    }
            }
    }
    
    public function actionEvaluacion($idevaluacion){

        $model = $this->cargarModelo($idevaluacion);
        $this->render('nuevaevaluacion',array(
                    'model'=>$model,
            ));
    }

    public function actionNuevaEvaluacion($idevaluacion){

        $model = $this->loadModel($idevaluacion);
        $this->render('nuevaevaluacion',array(
                    'model'=>$model,
            ));
    }

    public function actionCrearEvaluacionDesempeno(){
        if(isset($_POST['compromisoeva'])&&isset($_POST['competenciaeva'])){

                $idevaluacion = $this->convertirstringnumerico($_SESSION['dataevaluacion']['idevaluacion']);
                $evaluacion = EvaluacionDesempeno::model()->findByPk($idevaluacion);

                $evaluacion->fecharegistroevaluacion = $this->fechaphptomysql(date('d-m-Y'));
                $evaluacion->comentarioevaluacion = trim($_POST['comentario']);
                $evaluacion->promediocompromisos = $this->convertirstringnumerico($_SESSION['dataevaluacion']['promcompromisos']);
                $evaluacion->promediocompetencias = $this->convertirstringnumerico($_SESSION['dataevaluacion']['promcompetencias']);
                $evaluacion->promedioevaluacion = $this->convertirstringnumerico($_SESSION['dataevaluacion']['promtotal']);
                $evaluacion->estadoevaluacion = self::ZERO;

                $transaction = Yii::app()->db->beginTransaction();                      

                $result = $evaluacion->save();   

                if($result){

                    $compromisos = $_POST['compromisoeva'];
                    foreach($compromisos as $key => $value)
                    {                            
                        $compromiso = Compromiso::model()->findByPk($key);
                        $compromiso->puntaje = $this->convertirstringnumerico($value);                            
                        $result = $compromiso->save();
                    }
                    if($result)
                    {        
                        $competencias = $_POST['competenciaeva'];
                        foreach($competencias as $key => $value)
                        {
                            $evaluacioncompetencia = new EvaluacionCompetencia();                            
                            $evaluacioncompetencia->evaluacion = $evaluacion->id;
                            $evaluacioncompetencia->competencia = $this->convertirstringnumerico($key);
                            $evaluacioncompetencia->puntaje = $this->convertirstringnumerico($value);                                                          
                            $result = $evaluacioncompetencia->save();
                        }
                        if($result){
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', 'Se ha ingresado correctamente la evaluación del colaborador '.$evaluacion->_colaborador->nombre.' '.$evaluacion->_colaborador->apellido1.' '.$evaluacion->_colaborador->apellido2);
                            $this->redirect(array('site/index'));
                        }else{
                            $transaction->rollBack();                  
                            Yii::app()->user->setFlash('warning', 'Ha ocurrido un inconveniente al intentar guardar la evaluación del colaborador '.$evaluacion->_colaborador->nombre.' '.$evaluacion->_colaborador->apellido1.' '.$evaluacion->_colaborador->apellido2);                             
                            $this->redirect(array('site/index'));
                        }
                    }else{
                        $transaction->rollBack();                  
                        Yii::app()->user->setFlash('warning', 'Ha ocurrido un inconveniente al intentar guardar la evaluación del colaborador '.$evaluacion->_colaborador->nombre.' '.$evaluacion->_colaborador->apellido1.' '.$evaluacion->_colaborador->apellido2);                             
                        $this->redirect(array('site/index'));
                    }
                }else{
                     $transaction->rollBack();                  
                     Yii::app()->user->setFlash('warning', 'Ha ocurrido un inconveniente al intentar guardar la evaluación del colaborador '.$evaluacion->_colaborador->nombre.' '.$evaluacion->_colaborador->apellido1.' '.$evaluacion->_colaborador->apellido2);                             
                     $this->redirect(array('site/index'));
                }
        }
    }
    
    public function actionProcesarEvaluacionCompromisos() {                         
        if (isset($_POST['action'])) {
            $action = $_POST['action'];  
            $response = array();            
            if ($action == 'procesarevacompromisos') {    

                    $evaid = $_POST['evaid'];//Obtengo el id del ddl
                    $eva = $_POST['eva'];//Obtengo la calificacion recibida para ese compromiso

                    if($eva == self::STRING_NULL){       
                        $promedio = $this->logicaponderacioncompromisos(true, $evaid, $eva);                                                        
                        $response = array('ok' => false,'valor' => strval($promedio),'msg' => 'Seleccione un valor', 'id' => $evaid, 'valortotal' => strval($this->obtenerponderaciontotal()));
                    }
                    else{                                                          
                        $promedio = $this->logicaponderacioncompromisos(false, $evaid, $eva);                           
                        $response = array('ok' => true,'valor' => strval($promedio), 'id' => $evaid, 'valortotal' => strval($this->obtenerponderaciontotal()));
                    }
                    echo CJSON::encode($response);
             }
        }
    }

    public function actionProcesarEvaluacionCompetencias(){
        if (isset($_POST['action'])) {
            $action = $_POST['action'];  
            $response = array();            
            if ($action == 'procesarevacompetencias') {   

                    $evaid = $_POST['evaid'];//Obtengo el id del ddl
                    $eva = $_POST['eva'];//Obtengo la calificacion recibida para esa competencia

                    if($eva == self::STRING_NULL){       
                        $promedio = $this->logicaponderacioncompetencias(true, $evaid, $eva);                                                        
                        $response = array('ok' => false,'valor' => strval($promedio),'msg' => 'Seleccione un valor', 'id' => $evaid, 'valortotal' => $this->obtenerponderaciontotal());
                    }
                    else{                                                          
                        $promedio = $this->logicaponderacioncompetencias(false, $evaid, $eva);                           
                        $response = array('ok' => true,'valor' => strval($promedio), 'id' => $evaid, 'valortotal' => $this->obtenerponderaciontotal());
                    }
                    echo CJSON::encode($response);
             }
        }
    }
    
    //Operaciones

    protected function obtenerpuntualizaciones($idpuesto){

            $puesto = Puesto::model()->findByPk($idpuesto);

            $html = '';

            $html .= '<table class="table_ingreso_competencias" id="tblpuntualizaciones">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>Puntualización</th>';
            $html .= '<th>Indicador</th>';
            $html .= '<th>Compromiso</th>';                   
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach($puesto->_puntualizaciones as $puntualizacion)
                    {
                            $html .= '<tr>';
                                $html .= '<td class="data_puntualizacion_column">'. $puntualizacion->puntualizacion ."</td>";
                                $html .= '<td class="data_indicador_column">'. $puntualizacion->indicadorpuntualizacion ."</td>";
                                $html .= '<td class="textarea_column"><textarea name="puntualizacion['.$puntualizacion->id.']"></textarea></td>';
                            $html .= '</tr>';
                    }   
            $html .= '</tbody>';
            $html .= '</table>';

            return $html;
    }

    protected function obtenerpuntualizacionesevaluar($idevaluacion,$idpuesto){

            $puesto = Puesto::model()->findByPk($idpuesto);                
            $evaluacion = EvaluacionDesempeno::model()->findByPk($idevaluacion);           


            if(!(count($puesto->_puntualizaciones) == count($evaluacion->_compromisos)))
                Yii::app()->user->setFlash('error', 'Lo sentimos, ha ocurrido un error obteniendo los compromisos.');
            else{

            //Reinicio la session para cada nueva evaluacion
            unset($_SESSION['dataevalcompromisos']);//Se utiliza para guardar la calificacion de cada compromisos
            unset($_SESSION['dataevaluacion']);
            $_SESSION['dataevaluacion']['idevaluacion'] = $evaluacion->id;//Almaceno el id de la evaluacion para utilizarlo en el momento de crear la evaluacion
             //Almaceno la cantidad de puntualizaciones para luego utilizarla cuando califico los compromisos                
            $_SESSION['dataevaluacion']['cantpuntualizaciones'] = count($puesto->_puntualizaciones);

            $html = '';

            $html .= '<table class="table_evaluacion_compromisos" id="tblcompromisos">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>Puntualización</th>';
            $html .= '<th>Indicador</th>';
            $html .= '<th>Compromiso</th>';    
            $html .= '<th>Evaluación</th>';                
            $html .= '</tr>';
            $html .= '<thead>';
            $html .= '<tbody>';

            foreach($evaluacion->_compromisos as $compromiso)
                    {
                            $html .= '<tr>';
                                $html .= '<td class="data_column">'. $compromiso->_puntualizacion->puntualizacion ."</td>";
                                $html .= '<td class="data_column">'. $compromiso->_puntualizacion->indicadorpuntualizacion ."</td>";
                                $html .= '<td class="data_compromiso_column">'.$compromiso->compromiso.'</td>';                                    
                                $html .= '<td class="ddl_column">'. CHtml::dropDownList('compromisoeva['.$compromiso->id.']', '',CHtml::listData(Puntaje::model()->findAll(), "valor", "nombre"), array("empty"=>"Elija un calificacion", "id"=>"compromisoeva_".$compromiso->id."")).'</td>';
                            $html .= '</tr>';
                    }
            $html .= '</tbody>';
            $html .= '<tfoot>';
            $html .= '<tr>';
                                $html .= '<td></td>';
                                $html .= '<td></td>';
                                $html .= '<td>Promedio</td>';                                    
                                $html .= '<td class="promedio_column" id="compromisoprom" name="compromisoprom">0.0</td>';                                    
            $html .= '</tr>';
            $html .= '</tfoot>';
            $html .= '</table>';

            return $html;
            }
    }

    protected function obtenercompetenciasevaluar($idpuesto){

            $puesto = Puesto::model()->findByPk($idpuesto);

            if(count($puesto->_competencias) <= self::ZERO)
                Yii::app()->user->setFlash('error', 'Lo sentimos, ha ocurrido un error obteniendo las competencias.');
            else{

                //Reinicio la session para cada nueva evaluacion
                unset($_SESSION['dataevalcompetencias']);//Se utiliza para guardar la calificacion de cada compromisos
                //unset($_SESSION['dataevaluacion']); No se realiza unset a dataevaluacion debido a que ya contiene la cantidad de puntualizaciones.
                //Almaceno la cantidad de competencias para luego utilizarla cuando califico los competencias
                $_SESSION['dataevaluacion']['cantcompetencias'] = count($puesto->_competencias);

                $html = '';

                $html .= '<table class="table_evaluacion_competencias" id="tblcompetencias">';                    
                $html .= '<thead>';
                $html .= '<tr>';
                $html .= '<th>Indicador/Definición</th>';
                $html .= '<th>Competencia</th>';               
                $html .= '<th>Evaluación</th>';                   
                $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody>';

                foreach($puesto->_competencias as $competencia)
                        {
                                $html .= '<tr>';
                                    $html .= '<td>'. $competencia->competencia."</td>";
                                    $html .= '<td class="data_column">'. $competencia->descripcion."</td>";                                    
                                    $html .= '<td class="ddl_column">'. CHtml::dropDownList('competenciaeva['.$competencia->id.']', '',CHtml::listData(Puntaje::model()->findAll(), "valor", "nombre"), array("empty"=>"Elija un calificacion", "id"=>"competenciaeva_".$competencia->id."")).'</td>';
                                $html .= '</tr>';
                        }  
                $html .= '</tbody>';
                $html .= '<tfoot>';
                $html .= '<tr>';
                                    $html .= '<td class=""></td>';                                    
                                    $html .= '<td>Promedio</td>';                                    
                                    $html .= '<td class="promedio_column" id="competenciaprom" name="competenciaprom">0.0</td>';
                $html .= '</tr>';
                $html .= '</tfoot>';
                $html .= '</table>';

                return $html;
            }
    }

    protected function logicaponderacioncompromisos($error, $id, $valor){                                  
        if($error){
         $_SESSION['dataevalcompromisos'][$id] = self::ZERO;
        }else {            
         $_SESSION['dataevalcompromisos'][$id] = $valor;
        } 
        $calificacion = self::ZERO;
        $cantpuntualizaciones = $_SESSION['dataevaluacion']['cantpuntualizaciones'];
        foreach ($_SESSION['dataevalcompromisos'] as $key => $value){
         $calificacion = $calificacion + $value;
        }
        $promedio = $calificacion / $cantpuntualizaciones;
        if(is_float($promedio))
            $promedio = number_format ($promedio, 2);
        $_SESSION['dataevaluacion']['promcompromisos'] = $promedio;

        return $promedio;
    }

    protected function logicaponderacioncompetencias($error, $id, $valor){                                               
        if($error){
         $_SESSION['dataevalcompetencias'][$id] = self::ZERO;
        }else {            
         $_SESSION['dataevalcompetencias'][$id] = $valor;
        } 
        $calificacion = self::ZERO;
        $cantcompetencias = $_SESSION['dataevaluacion']['cantcompetencias'];
        foreach ($_SESSION['dataevalcompetencias'] as $key => $value){
         $calificacion = $calificacion + $value;
        }
        $promedio = $calificacion / $cantcompetencias;
        if(is_float($promedio))
            $promedio = number_format ($promedio, 2);
        $_SESSION['dataevaluacion']['promcompetencias'] = $promedio;

        return $promedio;
    }

    protected function logicaponderaciontotal(){            
        $_SESSION['dataevaluacion']['promtotal'] = self::ZERO;

        $promcompromisos = self::ZERO;
        $promcompetencias = self::ZERO;

        if(isset($_SESSION['dataevaluacion']['promcompromisos']))                
            $promcompromisos = $this->convertirstringnumerico($_SESSION['dataevaluacion']['promcompromisos']) * self::PORCENTAJECOMPROMISOS;
        if(isset($_SESSION['dataevaluacion']['promcompetencias']))
            $promcompetencias = $this->convertirstringnumerico($_SESSION['dataevaluacion']['promcompetencias']) * self::PORCENTAJECOMPETENCIAS;

        $promtotal = $promcompromisos + $promcompetencias;
        if(is_float($promtotal))
            $promtotal = number_format ($promtotal, 2);
        $_SESSION['dataevaluacion']['promtotal'] = $promtotal;
    }

    protected function obtenerponderaciontotal(){
        $this->logicaponderaciontotal();
        if(isset($_SESSION['dataevaluacion']['promtotal'])){
            $promtotal = $_SESSION['dataevaluacion']['promtotal'];
            return $promtotal;
        }else
            return $promtotal = self::ZERO;
    }

    public function actionvalidarcompromisos(){
        $response = array('ok' => true,'msg' => '');
        if(isset($_POST['puntualizacion'])){

        }elseif(isset($_POST['periodo'])){
            $periodo = $_POST['periodo'];
            if($periodo == self::STRING_NULL){

            }
        }elseif(isset($_POST['fechaevaluacion'])){

        }
    }
        
    //Miscellaneous
    
    public function obtenerfechahoy(){
        return date('d-m-Y');
    }      

    protected function fechaphptomysql($fechaphp) {
        try {
            list($d, $m, $y) = explode('-', $fechaphp); //El formato de la fecha parametro es d-m-Y
            $nuevafecha = mktime(0, 0, 0, $m, $d, $y);
            $fechamysql = strftime('%Y-%m-%d', $nuevafecha);
        } catch (Exception $e) { //El catch no ejecuta ninguna funcion porque las excepciones son manejas por el CErrorHandler de Yii.                
        }
        return $fechamysql;
    }

    protected function FechaMysqltoPhp($pfechamysql){
        try{
            $fecha = substr($pfechamysql, 0, 10);
            list($y, $m, $d) = explode('-', $fecha);               
            $fecha = $d.'-'.$m.'-'.$y;                 
        }
        catch (Exception $e){  
        } 
        return $fecha;
    }

    protected function convertirstringnumerico($pstring) {//Para utilizar esta funcion se debe comprobar con anticipacion que el var es numerico
    if ((float) $pstring != (int) $pstring)
        return (float) $pstring;
    else
        return (int) $pstring;
    }
    
    public function cargarModelo($id){
            $model = EvaluacionDesempeno::model()->findByPk($id);
            if($model===null)
                    throw new CHttpException(404,'La pagina solicitada no existe.');
            return $model;
    }
}