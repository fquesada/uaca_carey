<?php

/**
 * This is the model class for table "evaluacioncompetencia".
 *
 * The followings are the available columns in table 'evaluacioncompetencia':
 * @property integer $id
 * @property integer $evaluacion
 * @property integer $competencia
 * @property integer $escala
 * @property integer $puntaje
 *
 * The followings are the available model relations:
 * @property Competencia $_competencia
 * @property Evaluaciondesempeno $_evaluacion
 * @property Puntaje $_puntaje
 */
class Evaluacioncompetencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluacioncompetencia the static model class
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
		return 'evaluacioncompetencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evaluacion, competencia', 'required'),
			array('evaluacion, competencia, escala, puntaje', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, evaluacion, competencia, escala, puntaje', 'safe', 'on'=>'search'),
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
			'_competencia' => array(self::BELONGS_TO, 'Competencia', 'competencia'),
			'_evaluacion' => array(self::BELONGS_TO, 'Evaluaciondesempeno', 'evaluacion'),
			'_puntaje' => array(self::BELONGS_TO, 'Puntaje', 'puntaje'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'evaluacion' => 'Evaluacion',
			'competencia' => 'Competencia',
			'escala' => 'Escala',
			'puntaje' => 'Puntaje',
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
		$criteria->compare('evaluacion',$this->evaluacion);
		$criteria->compare('competencia',$this->competencia);
		$criteria->compare('escala',$this->escala);
		$criteria->compare('puntaje',$this->puntaje);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}