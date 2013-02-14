<?php

/**
 * This is the model class for table "unidadnegociopuesto".
 *
 * The followings are the available columns in table 'unidadnegociopuesto':
 * @property integer $unidadnegocio
 * @property integer $puesto
 *
 * The followings are the available model relations:
 * @property Colaborador[] $_colaboradorunidadnegocio
 * @property Colaborador[] $_colaboradorpuesto
 * @property HistoricoPuesto[] $_historicopuestounidadnegocio
 * @property HistoricoPuesto[] $_historicopuestopuesto
 */
class UnidadNegocioPuesto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UnidadNegocioPuesto the static model class
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
			'_colaboradorunidadnegocio' => array(self::HAS_MANY, 'Colaborador', 'unidadnegocio'),
			'_colaboradorpuesto' => array(self::HAS_MANY, 'Colaborador', 'puesto'),
			'_historicopuestounidadnegocio' => array(self::HAS_MANY, 'HistoricoPuesto', 'unidadnegocio'),
			'_historicopuestopuesto' => array(self::HAS_MANY, 'HistoricoPuesto', 'puesto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'unidadnegocio' => 'Unidad de negocio',
			'puesto' => 'Puesto',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($un)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('unidadnegocio',$this->unidadnegocio);
		$criteria->compare('puesto',$this->puesto);
                
                $criteria->addColumnCondition(array('unidadnegocio'=>$un));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}