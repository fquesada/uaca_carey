<?php

/**
 * This is the model class for table "evaluaciondesempeno".
 *
 * The followings are the available columns in table 'evaluaciondesempeno':
 * @property integer $id
 * @property integer $colaborador
 * @property integer $puesto
 * @property string $fecharegistrocompromiso
 * @property string $fechaevaluacion
 * @property string $comentariocompromisos
 * @property string $comentarioevaluacion
 * @property double $promediocompromisos
 * @property double $promediocompetencias
 * @property double $promedioevaluacion
 * @property string $fecharegistroevaluacion
 * @property integer $estadoevaluacion
 * @property integer $links
 * @property integer $procesoevaluacion
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Compromiso[] $_compromisos
 * @property Calificacioncompetencia[] $_calificacioncompetencias
 * @property Colaborador $_colaborador
 * @property Links $_links
 * @property Puesto $_puesto
 * @property Procesoevaluacion $_procesoevaluacion
 */
class Evaluaciondesempeno extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluaciondesempeno the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'evaluaciondesempeno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(			
                        array('colaborador, puesto, procesoevaluacion', 'required'),
			array('colaborador, puesto, estadoevaluacion, links, procesoevaluacion, estado', 'numerical', 'integerOnly'=>true),
			array('promediocompromisos, promediocompetencias, promedioevaluacion', 'numerical'),
			array('comentariocompromisos, comentarioevaluacion', 'length', 'max'=>800),
			array('fecharegistroevaluacion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, colaborador, puesto, fecharegistrocompromiso, fechaevaluacion, comentariocompromisos, comentarioevaluacion, promediocompromisos, promediocompetencias, promedioevaluacion, fecharegistroevaluacion, estadoevaluacion, links, procesoevaluacion, estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'_compromisos' => array(self::HAS_MANY, 'Compromiso', 'evaluacion'),
			'_calificacioncompetencias' => array(self::HAS_MANY, 'Calificacioncompetencia', 'evaluacion'),
			'_colaborador' => array(self::BELONGS_TO, 'Colaborador', 'colaborador'),			
			'_puesto' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
                        '_links' => array(self::BELONGS_TO, 'Links', 'links'),
                        '_procesoevaluacion' => array(self::BELONGS_TO, 'Procesoevaluacion', 'procesoevaluacion'),                      
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',			
			'colaborador' => 'Colaborador',
			'puesto' => 'Puesto',
			'fecharegistrocompromiso' => 'Fecharegistrocompromiso',
			'fechaevaluacion' => 'Fechaevaluacion',			
			'comentariocompromisos' => 'Comentariocompromisos',
			'comentarioevaluacion' => 'Comentarioevaluacion',
			'promediocompromisos' => 'Promediocompromisos',
			'promediocompetencias' => 'Promediocompetencias',
			'promedioevaluacion' => 'Promedioevaluacion',
			'fecharegistroevaluacion' => 'Fecharegistroevaluacion',
			'estadoevaluacion' => 'Estadoevaluacion',
                        'links' => 'Links',
			'procesoevaluacion' => 'Procesoevaluacion',                        
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('colaborador',$this->colaborador);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('fecharegistrocompromiso',$this->fecharegistrocompromiso,true);
		$criteria->compare('fechaevaluacion',$this->fechaevaluacion,true);
		$criteria->compare('comentariocompromisos',$this->comentariocompromisos,true);
		$criteria->compare('comentarioevaluacion',$this->comentarioevaluacion,true);
		$criteria->compare('promediocompromisos',$this->promediocompromisos);
		$criteria->compare('promediocompetencias',$this->promediocompetencias);
		$criteria->compare('promedioevaluacion',$this->promedioevaluacion);
		$criteria->compare('fecharegistroevaluacion',$this->fecharegistroevaluacion,true);
		$criteria->compare('estadoevaluacion',$this->estadoevaluacion);
                $criteria->compare('links',$this->links);
		$criteria->compare('procesoevaluacion',$this->procesoevaluacion);                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getEstadoEvaluacionDescripcion() {
            if ($this->estadoevaluacion == 1)
                return 'Pendiente';
            else if ($this->estadoevaluacion == 2)
                return 'Evaluado';
        }
        
        public function getEstadoEvaluacionIndicador() {
            if ($this->estadoevaluacion == 1)
                return false;
            else if ($this->estadoevaluacion == 2)
                return true;
        }
        
        public function getFechaEvaluacionFormato() {
            if (is_null($this->fecharegistroevaluacion))
                return "-- / -- / ----";
            else {
                $fechasinformato = strtotime($this->fecharegistroevaluacion);
                $fechaconformato = date('d-m-Y', $fechasinformato);
                return $fechaconformato;
            }
        }

        public function getFechaCompromisoEvaluacionFormato() {
            if (is_null($this->fechaevaluacion))
                return "-- / -- / ----";
            else {
                $fechasinformato = strtotime($this->fechaevaluacion);
                $fechaconformato = date('d-m-Y', $fechasinformato);
                return $fechaconformato;
            }
        }
        
        public function getEstadoCompromisosDescripcion(){
            if (is_null($this->fecharegistrocompromiso))
                return "Pendiente";
            else
                return "Registrado";            
        }
        
        public function getEstadoCompromisosIndicador(){
            if (is_null($this->fecharegistrocompromiso))
                return false;
            else
                return true;            
        }
            
        public function getFechaRegistroCompromisoFormato() {
            if (is_null($this->fecharegistrocompromiso))
                return "-- / -- / ----";
            else {
                $fechasinformato = strtotime($this->fecharegistrocompromiso);
                $fechaconformato = date('d-m-Y', $fechasinformato);
                return $fechaconformato;
            }
        }

        public function getNombreEvaluado() {
            if ($this->tipo == 1)
                return Colaborador::model()->findByPk($this->evaluado)->nombrecompleto;
            else
                return Postulante::model()->findByPk($this->evaluado)->nombrecompleto;
        }

    
        ///EVALUACION

        public function actionEvaluacion($idevaluacion) {
            $model = EvaluacionDesempeno::model()->findByPk($id);
            $this->render('evaluacion', array(
                'model' => $model,
            ));
        }

        protected function obtenerpuntualizacionesevaluar($idevaluacion, $idpuesto) {

            $puesto = Puesto::model()->findByPk($idpuesto);
            $evaluacion = EvaluacionDesempeno::model()->findByPk($idevaluacion);


            if (!(count($puesto->_puntualizaciones) == count($evaluacion->_compromisos)))
                Yii::app()->user->setFlash('error', 'Lo sentimos, ha ocurrido un error obteniendo los compromisos.');
            else {

                //Reinicio la session para cada nueva evaluacion
                unset($_SESSION['dataevalcompromisos']); //Se utiliza para guardar la calificacion de cada compromisos
                unset($_SESSION['dataevaluacion']);
                $_SESSION['dataevaluacion']['idevaluacion'] = $evaluacion->id; //Almaceno el id de la evaluacion para utilizarlo en el momento de crear la evaluacion
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

                foreach ($evaluacion->_compromisos as $compromiso) {
                    $html .= '<tr>';
                    $html .= '<td class="data_column">' . $compromiso->_puntualizacion->puntualizacion . "</td>";
                    $html .= '<td class="data_column">' . $compromiso->_puntualizacion->indicadorpuntualizacion . "</td>";
                    $html .= '<td class="data_compromiso_column">' . $compromiso->compromiso . '</td>';
                    $html .= '<td class="ddl_column">' . CHtml::dropDownList('compromisoeva[' . $compromiso->id . ']', '', CHtml::listData(Puntaje::model()->findAll(), "valor", "nombre"), array("empty" => "Elija un calificacion", "id" => "compromisoeva_" . $compromiso->id . "")) . '</td>';
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

        protected function obtenercompetenciasevaluar($idpuesto) {

            $puesto = Puesto::model()->findByPk($idpuesto);

            if (count($puesto->_competencias) <= self::ZERO)
                Yii::app()->user->setFlash('error', 'Lo sentimos, ha ocurrido un error obteniendo las competencias.');
            else {

                //Reinicio la session para cada nueva evaluacion
                unset($_SESSION['dataevalcompetencias']); //Se utiliza para guardar la calificacion de cada compromisos
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

                foreach ($puesto->_competencias as $competencia) {
                    $html .= '<tr>';
                    $html .= '<td>' . $competencia->competencia . "</td>";
                    $html .= '<td class="data_column">' . $competencia->descripcion . "</td>";
                    $html .= '<td class="ddl_column">' . CHtml::dropDownList('competenciaeva[' . $competencia->id . ']', '', CHtml::listData(Puntaje::model()->findAll(), "valor", "nombre"), array("empty" => "Elija un calificacion", "id" => "competenciaeva_" . $competencia->id . "")) . '</td>';
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
        
        public function calificacionCompetencias($competencias) {
            $dividendo = 0;
            $divisor = 0;

            foreach ($competencias as $competencia) {

                if (is_numeric($competencia["calificacion"])) {
                    $dividendo = $dividendo + CommonFunctions::stringtonumber($competencia["calificacion"]) * CommonFunctions::stringtonumber($competencia["ponderacion"]);
                    $divisor = $divisor + CommonFunctions::stringtonumber($competencia["ponderacion"]);
                }
            }

            if ($divisor == 0)
                $promedio = 0;
            else
                $promedio = $dividendo / $divisor;

            return $promedio;
        }

        public function calificacionPuntualizaciones($puntualizaciones) {
            $dividendo = 0;
            $divisor = 0;

            foreach ($puntualizaciones as $puntualizacion) {
                if (is_numeric($puntualizacion["calificacion"])) {
                    $dividendo = $dividendo + CommonFunctions::stringtonumber($puntualizacion["calificacion"]);
                    $divisor = $divisor + 1;
                }
            }

            if ($divisor == 0)
                $promedio = 0;
            else
                $promedio = $dividendo / $divisor;

            return $promedio;
        }
        
        public function califacionED($calificacionpuntualizaciones, $calificacioncompetencias){
            
            $calificacionpuntualizaciones = $calificacionpuntualizaciones * 0.80; //Regla de Consultoria - CLEAN CODE - Guardar en BD
            $calificacioncompetencias = $calificacioncompetencias * 0.20; //Regla de Consultoria - CLEAN CODE - Guardar en BD
            return $calificacionpuntualizaciones + $calificacioncompetencias;
        }
        
        public function cambiarEDFinalizada(){
            $this->estadoevaluacion = 2;
        }        
       
}