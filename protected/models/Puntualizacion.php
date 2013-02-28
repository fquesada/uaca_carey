<?php

/**
 * This is the model class for table "puntualizacion".
 *
 * The followings are the available columns in table 'puntualizacion':
 * @property integer $id
 * @property string $puntualizacion
 * @property string $indicadorpuntualizacion
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Compromiso[] $_compromisos
 * @property Puesto[] $_puestos
 */
class Puntualizacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Puntualizacion the static model class
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
		return 'puntualizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('puntualizacion, indicadorpuntualizacion', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('puntualizacion, indicadorpuntualizacion', 'length', 'max'=>800),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, puntualizacion, indicadorpuntualizacion, estado', 'safe', 'on'=>'search'),
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
			'_compromisos' => array(self::HAS_MANY, 'Compromiso', 'puntualizacion'),
			'_puestos' => array(self::MANY_MANY, 'Puesto', 'puestopuntualizacion(puntualizacion, puesto)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'puntualizacion' => 'Puntualizacion',
			'indicadorpuntualizacion' => 'Indicadorpuntualizacion',
			'estado' => 'Estado',
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
		$criteria->compare('puntualizacion',$this->puntualizacion,true);
		$criteria->compare('indicadorpuntualizacion',$this->indicadorpuntualizacion,true);
		$criteria->compare('estado',$this->estado);
                
                $criteria->addColumnCondition(array('estado'=>'1'));
            
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function addpuntualizacion($idpuesto)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('puntualizacion',$this->puntualizacion,true);
		$criteria->compare('indicadorpuntualizacion',$this->indicadorpuntualizacion,true);
		$criteria->compare('estado',$this->estado);
                
                $criteria->addColumnCondition(array('estado'=>'1'));
            
                $puntualizaciones = PuestoPuntualizacion::model()->findAllByAttributes(array('puesto'=>$idpuesto));
                $puntualizacionessasociadas = $this->obtenerArrayColumna($puntualizaciones, 'puntualizacion');
                $criteria->addNotInCondition('id', $puntualizacionessasociadas);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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