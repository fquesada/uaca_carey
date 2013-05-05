<?php

/**
 * This is the model class for table "evaluacioncompetencias".
 *
 * The followings are the available columns in table 'evaluacioncompetencias':
 * @property integer $id
 * @property integer $evaluacionpersonas
 * @property string $fechaevaluacion
 * @property integer $puestopotencial1
 * @property integer $puestopotencial2
 * @property integer $puestopotencial3
 * @property double $promedioponderado
 * @property integer $tipo
 * @property integer $evaluador
 * @property integer $evaluado
 * @property string $comentario
 *
 * The followings are the available model relations:
 * @property Puesto $_puestopotencial1
 * @property Puesto $_puestopotencial2
 * @property Puesto $_puestopotencial3
 * @property Evaluacionpersonas $_evaluacionpersonas
 * @property Colaborador $_evaluador
 * @property Habilidadespecialevaluada[] $_habilidadesespecialevaluada
 * @property Habilidadevaluacioncandidato[] $_habilidadesevaluacioncandidato
 * @property Habilidadnoequivalente[] $_habilidadesnoequivalente
 * @property Meritoevaluacioncandidato[] $_meritosevaluacioncandidato
 * @property Origenevaluacion[] $_origenesevaluacion
 */
class Evaluacioncompetencias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluacioncompetencias the static model class
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
		return 'evaluacioncompetencias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evaluacionpersonas, fechaevaluacion', 'required'),
			array('evaluacionpersonas, puestopotencial1, puestopotencial2, puestopotencial3, tipo, evaluador, evaluado', 'numerical', 'integerOnly'=>true),
			array('promedioponderado', 'numerical'),
                        array('comentario', 'length', 'max'=>800),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, evaluacionpersonas, fechaevaluacion, puestopotencial1, puestopotencial2, puestopotencial3, promedioponderado, tipo, evaluador, evaluado', 'safe', 'on'=>'search'),

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
			'_puestopotencial1' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial1'),
			'_puestopotencial2' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial2'),
			'_puestopotencial3' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial3'),
			'_evaluacionpersonas' => array(self::BELONGS_TO, 'Evaluacionpersonas', 'evaluacionpersonas'),
			'_evaluador' => array(self::BELONGS_TO, 'Colaborador', 'evaluador'),
                        '_evaluado' => array(self::BELONGS_TO, 'Colaborador', 'evaluado'),
			'_habilidadesespecialevaluada' => array(self::HAS_MANY, 'Habilidadespecialevaluada', 'evaluacioncompetencias'),
			'_habilidadesevaluacioncandidato' => array(self::HAS_MANY, 'Habilidadevaluacioncandidato', 'evaluacioncandidato'),
			'_habilidadesnoequivalente' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'evaluacioncandidato'),
			'_meritosevaluacioncandidato' => array(self::HAS_MANY, 'Meritoevaluacioncandidato', 'evaluacioncandidato'),
                        '_origenesevaluacion' => array(self::MANY_MANY, 'Origenevaluacion', 'evaluacioncompetenciasorigen(evaluacioncompetencias, origenevaluacion)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'evaluacionpersonas' => 'Evaluacionpersonas',
			'fechaevaluacion' => 'Fechaevaluacion',			
			'puestopotencial1' => 'Puestopotencial1',
			'puestopotencial2' => 'Puestopotencial2',
			'puestopotencial3' => 'Puestopotencial3',
			'promedioponderado' => 'Promedioponderado',
			'tipo' => 'Tipo',
			'evaluador' => 'Evaluador',
			'evaluado' => 'Evaluado',
                        'TipoEvaluado' => 'Tipo de Evaluado',
                        'NombreEvaluado' => 'Nombre de Evaluado',
                        'EstadoEvaluacion'=>'Estado de la Evaluación',                    
                        'comentario' => 'Comentario',

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
		$criteria->compare('evaluacionpersonas',$this->evaluacionpersonas);
		$criteria->compare('fechaevaluacion',$this->fechaevaluacion,true);		
		$criteria->compare('puestopotencial1',$this->puestopotencial1);
		$criteria->compare('puestopotencial2',$this->puestopotencial2);
		$criteria->compare('puestopotencial3',$this->puestopotencial3);
		$criteria->compare('promedioponderado',$this->promedioponderado);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('evaluador',$this->evaluador);
		$criteria->compare('evaluado',$this->evaluado);
                $criteria->compare('comentario',$this->comentario,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
         public function getTipoEvaluado()
        {
            $estado = 'Interno';
            if($this->tipo==0)
                $estado = 'Externo';
            
            return $estado;
        }
        
        public function getNombreEvaluado()
        {
            if($this->tipo==1)
                return Colaborador::model()->findByPk($this->evaluado)->nombrecompleto;
            else
                return Postulante::model()->findByPk($this->evaluado)->nombrecompleto;
        }
        
        public function getEstadoEvaluacion()
        {            
            if($this->promedioponderado != null)
                return 'Finalizado';
            else
                return 'Pendiente';
        }
        
//        public function obtenerGraficoSpiderCalificado($idevaluacioncompetencias,$idevaluacionpersonas){
//            
//            $connection=Yii::app()->db;
//            $sql = "SELECT tm.nombre as 'eje',mec.calificacion as 'calificacion'
//                    FROM meritoevaluacioncandidato mec
//                    INNER JOIN merito m ON mec.merito = m.id
//                    INNER JOIN tipomerito tm ON tm.id =  m.tipomerito
//                    WHERE mec.evaluacioncandidato = :idevaluacioncompetencias
//                    UNION
//                    SELECT c.competencia as 'eje',hec.calificacion as 'calificacion'
//                    FROM habilidadevaluacioncandidato hec
//                    INNER JOIN competencia c ON hec.competencia = c.id
//                    WHERE hec.evaluacioncandidato = :idevaluacioncompetencias
//                    UNION
//                    SELECT h.nombre as 'eje',he.calificacion as 'calificacion'
//                    FROM Habilidadespecialevaluada he
//                    INNER JOIN Habilidadespecial h ON he.evaluacionpersonas = h.evaluacionpersonas
//                    AND he.habilidadespecial = h.id
//                    WHERE he.evaluacionpersonas = :idevaluacionpersonas AND he.evaluacioncompetencias = :idevaluacioncompetencias";
//            $command = $connection->createCommand($sql);
//            $command->bindParam(":idevaluacionpersonas", $idevaluacionpersonas, PDO::PARAM_INT);
//            $command->bindParam(":idevaluacioncompetencias", $idevaluacioncompetencias, PDO::PARAM_INT);            
//            $dataspider = $command->queryAll();
//            
//            if(empty($dataspider))
//                return false;
//            else 
//                return $dataspider;
//        }
        
           public function obtenerdatosgraficospider($idevaluacioncompetencias,$idevaluacionpersonas){
            
            $connection=Yii::app()->db;
            $sql = "SELECT tm.nombre as 'eje',mec.calificacion as 'calificacion', mec.ponderacion as 'ponderacion'
                    FROM meritoevaluacioncandidato mec
                    INNER JOIN merito m ON mec.merito = m.id
                    INNER JOIN tipomerito tm ON tm.id =  m.tipomerito
                    WHERE mec.evaluacioncandidato = :idevaluacioncompetencias
                    UNION
                    SELECT c.competencia as 'eje',hec.calificacion as 'calificacion', hec.ponderacion as 'ponderacion'
                    FROM habilidadevaluacioncandidato hec
                    INNER JOIN competencia c ON hec.competencia = c.id
                    WHERE hec.evaluacioncandidato = :idevaluacioncompetencias
                    UNION
                    SELECT h.nombre as 'eje',he.calificacion as 'calificacion', h.ponderacion as 'ponderacion'
                    FROM Habilidadespecialevaluada he
                    INNER JOIN Habilidadespecial h ON he.evaluacionpersonas = h.evaluacionpersonas
                    AND he.habilidadespecial = h.id
                    WHERE he.evaluacionpersonas = :idevaluacionpersonas AND he.evaluacioncompetencias = :idevaluacioncompetencias";
            $command = $connection->createCommand($sql);
            $command->bindParam(":idevaluacionpersonas", $idevaluacionpersonas, PDO::PARAM_INT);
            $command->bindParam(":idevaluacioncompetencias", $idevaluacioncompetencias, PDO::PARAM_INT);            
            $dataspider = $command->queryAll();
            
            if(empty($dataspider))
                return false;
            else 
                return $dataspider;
        }
        
        

        
        public function obtenerGraficoSpiderRelativo($idevaluacioncompetencias,$idevaluacionpersonas){
            
            $connection=Yii::app()->db;
            if($this->tipo==1){          
            $sql = "SELECT tm.nombre as 'eje', m.ponderacion as 'calificacion'
                    FROM evaluacioncompetencias ec                     
                    INNER JOIN colaborador co ON ec.evaluado = co.id
                    INNER JOIN unidadnegociopuesto up ON co.puesto = up.puesto
                    INNER JOIN puesto p ON up.puesto = p.id
                    INNER JOIN merito m ON m.puesto = p.id
                    INNER JOIN tipomerito tm ON tm.id =  m.tipomerito                    
                    AND ec.id = :idevaluacioncompetencias
                    UNION
                    SELECT c.competencia as 'eje', pc.ponderacion as 'calificacion'
                    FROM habilidadevaluacioncandidato hec
                    INNER JOIN evaluacioncompetencias ec ON hec.evaluacioncandidato = ec.id
                    INNER JOIN competencia c ON hec.competencia = c.id
                    INNER JOIN puestocompetencia pc ON c.id = pc.competencia
                    INNER JOIN colaborador co ON ec.evaluado = co.id
                    INNER JOIN unidadnegociopuesto up ON co.puesto = up.puesto
                    INNER JOIN puesto p ON up.puesto = p.id
                    WHERE pc.puesto = p.id
                    AND hec.evaluacioncandidato = :idevaluacioncompetencias
                    UNION
                    SELECT he.nombre as 'eje',he.ponderacion as 'calificacion'
                    FROM Habilidadespecial he
                    INNER JOIN evaluacionpersonas e ON he.evaluacionpersonas = e.id
                    WHERE he.evaluacionpersonas = :idevaluacionpersonas";                    
            }
            $command = $connection->createCommand($sql);
            $command->bindParam(":idevaluacionpersonas", $idevaluacionpersonas, PDO::PARAM_INT);
            $command->bindParam(":idevaluacioncompetencias", $idevaluacioncompetencias, PDO::PARAM_INT);            
            $dataspider = $command->queryAll();
            
            if(empty($dataspider))
                return false;
            else 
                return $dataspider;
        }
}
