<?php

/**
 * This is the model class for table "puestocompetencia".
 *
 * The followings are the available columns in table 'puestocompetencia':
 * @property integer $competencia
 * @property integer $puesto
 * @property integer $ponderacion
 */
class Puestocompetencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Puestocompetencia the static model class
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
		return 'puestocompetencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('competencia, puesto, ponderacion', 'required'),
			array('competencia, puesto, ponderacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('competencia, puesto, ponderacion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'competencia' => 'Competencia',
			'puesto' => 'Puesto',
			'ponderacion' => 'Ponderación',
		);
	}

        public function getNombreCompetencia(){
            
            $competencia = Competencia::model()->findAllByAttributes(array('id'=>$this->competencia));
            foreach ($competencia as $comp){
                $resultado = $comp->competencia;
            }
            return $resultado;
            
        }

        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('competencia',$this->competencia);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('ponderacion',$this->ponderacion);
                
                $criteria->addColumnCondition(array('puesto'=>$id));
                
                $competencias = Competencia::model()->findAllByAttributes(array('estado'=>'1'));
                $competenciasactivas = $this->obtenerArrayColumna($competencias, 'id');
                
                $criteria->addInCondition('competencia', $competenciasactivas);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array('pageSize'=>'10'),
		));
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