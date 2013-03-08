<?php

/**
 * This is the model class for table "vacante".
 *
 * The followings are the available columns in table 'vacante':
 * @property integer $id
 * @property integer $periodo
 * @property string $fechareclutamiento
 * @property string $fechaseleccion
 * @property integer $evaluacionpersonas
 * @property integer $unidadnegocio
 *
 * The followings are the available model relations:
 * @property Periodo $_periodo
 * @property Evaluacionpersonas $_evaluacionpersonas
 * @property Unidadnegocio $_unidadnegocio
 */
class Vacante extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vacante the static model class
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
		return 'vacante';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodo, unidadnegocio', 'required'),
			array('periodo, evaluacionpersonas, unidadnegocio', 'numerical', 'integerOnly'=>true),
			array('fechareclutamiento, fechaseleccion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, periodo, fechareclutamiento, fechaseleccion, evaluacionpersonas, unidadnegocio', 'safe', 'on'=>'search'),
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
			'_periodo' => array(self::BELONGS_TO, 'Periodo', 'periodo'),
			'_evaluacionpersonas' => array(self::BELONGS_TO, 'Evaluacionpersonas', 'evaluacionpersonas'),
			'_unidadnegocio0' => array(self::BELONGS_TO, 'Unidadnegocio', 'unidadnegocio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'periodo' => 'Periodo',
			'fechareclutamiento' => 'Fechareclutamiento',
			'fechaseleccion' => 'Fechaseleccion',
			'evaluacionpersonas' => 'Evaluacionpersonas',
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
		$criteria->compare('periodo',$this->periodo);
		$criteria->compare('fechareclutamiento',$this->fechareclutamiento,true);
		$criteria->compare('fechaseleccion',$this->fechaseleccion,true);
		$criteria->compare('evaluacionpersonas',$this->evaluacionpersonas);
		$criteria->compare('unidadnegocio',$this->unidadnegocio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}