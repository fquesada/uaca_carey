<?php

/**
 * This is the model class for table "entrevistanormal".
 *
 * The followings are the available columns in table 'entrevistanormal':
 * @property integer $id
 * @property integer $entrevista
 * @property integer $puesto
 * @property integer $unidadnegocio
 *
 * The followings are the available model relations:
 * @property Entrevista $_entrevista
 * @property Unidadnegociopuesto $_puesto
 * @property Unidadnegociopuesto $_unidadnegocio
 */
class Entrevistanormal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Entrevistanormal the static model class
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
		return 'entrevistanormal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entrevista, puesto, unidadnegocio', 'required'),
			array('entrevista, puesto, unidadnegocio', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, entrevista, puesto, unidadnegocio', 'safe', 'on'=>'search'),
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
			'_entrevista' => array(self::BELONGS_TO, 'Entrevista', 'entrevista'),
			'_puesto' => array(self::BELONGS_TO, 'Unidadnegociopuesto', 'puesto'),
			'_unidadnegocio' => array(self::BELONGS_TO, 'Unidadnegociopuesto', 'unidadnegocio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'entrevista' => 'Entrevista',
			'puesto' => 'Puesto',
			'unidadnegocio' => 'Unidadnegocio',
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
		$criteria->compare('entrevista',$this->entrevista);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('unidadnegocio',$this->unidadnegocio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}