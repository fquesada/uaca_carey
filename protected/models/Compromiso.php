<?php

/**
 * This is the model class for table "compromiso".
 *
 * The followings are the available columns in table 'compromiso':
 * @property integer $id
 * @property string $compromiso
 * @property integer $evaluacion
 * @property integer $puntualizacion
 * @property integer $puntaje
 *
 * The followings are the available model relations:
 * @property EvaluacionDesempeno $_evaluacion
 * @property Puntualizacion $_puntualizacion
 * @property Puntaje $_puntaje
 */
class Compromiso extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Compromiso the static model class
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
		return 'compromiso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('compromiso, evaluacion, puntualizacion', 'required'),
			array('evaluacion, puntualizacion, puntaje', 'numerical', 'integerOnly'=>true),
			array('compromiso', 'length', 'max'=>800),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, compromiso, evaluacion, puntualizacion, puntaje', 'safe', 'on'=>'search'),
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
			'_evaluacion' => array(self::BELONGS_TO, 'EvaluacionDesempeno', 'evaluacion'),
			'_puntualizacion' => array(self::BELONGS_TO, 'Puntualizacion', 'puntualizacion'),
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
			'compromiso' => 'Compromiso',
			'evaluacion' => 'Evaluacion',
			'puntualizacion' => 'Puntualizacion',			
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
		$criteria->compare('compromiso',$this->compromiso,true);
		$criteria->compare('evaluacion',$this->evaluacion);
		$criteria->compare('puntualizacion',$this->puntualizacion);		
		$criteria->compare('puntaje',$this->puntaje);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}