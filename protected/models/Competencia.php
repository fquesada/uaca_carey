<?php

/**
 * This is the model class for table "competencia".
 *
 * The followings are the available columns in table 'competencia':
 * @property integer $id
 * @property string $competencia
 * @property string $descripcion
 * @property string $pregunta
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Calificacioncompetencia[] $_calificacioncompetencias
 * @property Habilidadevaluacioncandidato[] $_habilidadesevaluacioncandidato
 * @property Habilidadnoequivalente[] $_habilidadesnoequivalente
 * @property Puesto[] $_puestos
 */
class Competencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Competencia the static model class
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
		return 'competencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('competencia, descripcion, pregunta', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('competencia', 'length', 'max'=>400),
			array('descripcion', 'length', 'max'=>800),
			array('pregunta', 'length', 'max'=>1500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, competencia, descripcion, pregunta, estado, tipocompetencia', 'safe', 'on'=>'search'),
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
			'_calificacioncompetencias' => array(self::HAS_MANY, 'Calificacioncompetencia', 'competencia'),
			'_habilidadesevaluacioncandidato' => array(self::HAS_MANY, 'Habilidadevaluacioncandidato', 'competencia'),
			'_habilidadesnoequivalente' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'competencia'),
			'_puestos' => array(self::MANY_MANY, 'Puesto', 'puestocompetencia(competencia, puesto)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'competencia' => 'Competencia',
                        'tipocompetencia'=>'Tipo de competencia',
			'descripcion' => 'Descripción',
			'pregunta' => 'Entrevista Conductual Estructurada',
			'estado' => 'Estado',
                        'tipocomp'=>'Tipo de competencia'
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
		$criteria->compare('competencia',$this->competencia,true);
                $criteria->compare('tipocompetencia',$this->tipocompetencia,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('pregunta',$this->pregunta,true);
		$criteria->compare('estado',$this->estado);
                
                $criteria->addColumnCondition(array('estado'=>'1'));
                
                $criteria->order = 'competencia';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>'10'),
		));
	}
        
        public function addcompetencia($id){
            
            $connection = Yii::app()->db;            
            $sql = "SELECT competencia.id, competencia.competencia, competencia.descripcion, (CASE WHEN competencia.tipocompetencia = 1 THEN 'CORE' ELSE 'Específica' END) as tipocompetencia
                FROM competencia
                WHERE competencia.estado = 1 AND competencia.id NOT IN(SELECT competencia.id              
                FROM puesto
                INNER JOIN puestocompetencia
                ON (puesto.id = puestocompetencia.puesto)
                INNER JOIN competencia
                ON (puestocompetencia.competencia = competencia.id)
                WHERE puesto = :idpuesto)
                ORDER BY competencia.competencia";
            $command = $connection->createCommand($sql);
            $command->bindParam(":idpuesto", $id, PDO::PARAM_INT);
            
            $competencias = $command->queryAll();
            
            $dataProvider = new CArrayDataProvider($competencias, array(
               'keyField'=>'id',
               'id'=>'competenciaexistente-grid',
               'sort'=>array(
                   'attributes'=>array(
                       'competencia',
                       'descripcion',
                       'tipocompetencia',
                       ),
                   ),
                   'pagination'=>array(
                       'pageSize'=>10,
                   ),
               ));
            
            $filtersForm = new FiltersForm;
            if (isset($_GET['FiltersForm']))
               $filtersForm->filters=$_GET['FiltersForm'];                       
            $filtro = $filtersForm->filter($dataProvider);            
            return $filtro;
             
        }
        
        public function competenciaasociados($id){
            $criteria = new CDbCriteria;
            
            $criteria->compare('id',$this->id);
            $criteria->compare('competencia',$this->competencia,true);
            $criteria->compare('tipocompetencia',$this->tipocompetencia,true);
            $criteria->compare('descripcion',$this->descripcion,true);
            $criteria->compare('pregunta',$this->pregunta,true);
            $criteria->compare('estado',$this->estado);
            $criteria->addColumnCondition(array('estado'=>'1'));
            
            $competencias = Puestocompetencia::model()->findAllByAttributes(array('puesto'=>$id));
            $competenciasasociadas = $this->obtenerArrayColumna($competencias, 'competencia');
            $criteria->addInCondition('id', $competenciasasociadas);
            
            $criteria->order = 'competencia';
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>'10'),
            ));
            
            
        }
        
        public function gettipocomp(){
            if($this->tipocompetencia == 1)        
                return "CORE";
            else
                return "Específica";
        }
        
        /**
         * Returns an array with the values of the column needed.
         * @param array $unidades the array with the objects that have the column needed
         * @param string $columna  the name of the column that must be obtain
         */

           public function obtenerArrayColumna($unidades, $columna)
        {
            $idUnidades = array();
            foreach ($unidades as $un) {
                $idUnidades[] = $un->$columna;
            }
            return $idUnidades;
        }
}
