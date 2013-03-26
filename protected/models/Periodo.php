<?php

/**
 * This is the model class for table "periodo".
 *
 * The followings are the available columns in table 'periodo':
 * @property integer $id
 * @property string $nombre
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Evaluaciondesempeno[] $_evaluacionsdesempeno
 * @property Vacante[] $_vacantes
 */
class Periodo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Periodo the static model class
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
		return 'periodo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, estado', 'safe', 'on'=>'search'),
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
			'_evaluacionsdesempeno' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'periodo'),
			'_vacantes' => array(self::HAS_MANY, 'Vacante', 'periodo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('estado',$this->estado);
                
                $criteria->addColumnCondition(array('estado'=>'1'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
