<?php

/**
 * This is the model class for table "historicopuesto".
 *
 * The followings are the available columns in table 'historicopuesto':
 * @property integer $id
 * @property string $fechadesignacion
 * @property integer $colaborador
 * @property integer $puesto
 *
 * The followings are the available model relations:
 * @property Colaborador $colaborador0
 * @property Puesto $puesto0
 */
class Historicopuesto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Historicopuesto the static model class
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
		return 'historicopuesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fechadesignacion, colaborador, puesto', 'required'),
			array('colaborador, puesto', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fechadesignacion, colaborador, puesto', 'safe', 'on'=>'search'),
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
			'_colaborador' => array(self::BELONGS_TO, 'Colaborador', 'colaborador'),
			'_puesto' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechadesignacion' => 'Fechadesignacion',
			'colaborador' => 'Colaborador',
			'puesto' => 'Puesto',
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
		$criteria->compare('fechadesignacion',$this->fechadesignacion,true);
		$criteria->compare('colaborador',$this->colaborador);
		$criteria->compare('puesto',$this->puesto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}