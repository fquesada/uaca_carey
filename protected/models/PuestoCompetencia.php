<?php

/**
 * This is the model class for table "puestocompetencia".
 *
 * The followings are the available columns in table 'puestocompetencia':
 * @property integer $competencia
 * @property integer $puesto
 * @property integer $ponderacion
 */
class PuestoCompetencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PuestoCompetencia the static model class
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
			'ponderacion' => 'Ponderacion',
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

		$criteria->compare('competencia',$this->competencia);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('ponderacion',$this->ponderacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}