<?php

/**
 * This is the model class for table "entrevista".
 *
 * The followings are the available columns in table 'entrevista':
 * @property integer $id
 * @property integer $vacante
 * @property string $fecha
 * @property integer $entrevistador
 * @property integer $entrevistado
 * @property integer $tipo
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Vacante $_vacante
 * @property Colaborador $_entrevistador
 * @property Evaluacioncandidato[] $_evaluacioncandidatos
 */
class Entrevista extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Entrevista the static model class
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
		return 'entrevista';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vacante, fecha, entrevistador, entrevistado, tipo', 'required'),
			array('vacante, entrevistador, entrevistado, tipo, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vacante, fecha, entrevistador, entrevistado, tipo, estado', 'safe', 'on'=>'search'),
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
			'_vacante' => array(self::BELONGS_TO, 'Vacante', 'vacante'),
			'_entrevistador' => array(self::BELONGS_TO, 'Colaborador', 'entrevistador'),
			'_evaluacioncandidatos' => array(self::HAS_MANY, 'Evaluacioncandidato', 'entrevista'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vacante' => 'Vacante',
			'fecha' => 'Fecha',
			'entrevistador' => 'Entrevistador',
			'entrevistado' => 'Entrevistado',
			'tipo' => 'Tipo',
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
		$criteria->compare('vacante',$this->vacante);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('entrevistador',$this->entrevistador);
		$criteria->compare('entrevistado',$this->entrevistado);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}