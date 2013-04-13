<?php

/**
 * This is the model class for table "unidadnegociopuesto".
 *
 * The followings are the available columns in table 'unidadnegociopuesto':
 * @property integer $unidadnegocio
 * @property integer $puesto
 *
 * The followings are the available model relations:
 * @property Colaborador[] $_unidadesnegociocolaborador
 * @property Colaborador[] $_puestoscolaborador
 * @property Historicopuesto[] $_unidadesnegociohistoricopuesto
 * @property Historicopuesto[] $_puestoshistoricopuesto
 */
class Unidadnegociopuesto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Unidadnegociopuesto the static model class
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
		return 'unidadnegociopuesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unidadnegocio, puesto', 'required'),
			array('unidadnegocio, puesto', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('unidadnegocio, puesto', 'safe', 'on'=>'search'),
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
			'_unidadesnegociocolaborador' => array(self::HAS_MANY, 'Colaborador', 'unidadnegocio'),
			'_puestoscolaborador' => array(self::HAS_MANY, 'Colaborador', 'puesto'),
			'_unidadesnegociohistoricopuesto' => array(self::HAS_MANY, 'Historicopuesto', 'unidadnegocio'),
			'_puestoshistoricopuesto' => array(self::HAS_MANY, 'Historicopuesto', 'puesto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'unidadnegocio' => 'Unidadnegocio',
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

		$criteria->compare('unidadnegocio',$this->unidadnegocio);
		$criteria->compare('puesto',$this->puesto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}