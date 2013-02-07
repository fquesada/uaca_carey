<?php

/**
 * This is the model class for table "compromiso".
 *
 * The followings are the available columns in table 'compromiso':
 * @property integer $id
 * @property string $compromiso
 * @property integer $evaluacion
 * @property integer $puntualizacion
 * @property integer $escala
 * @property integer $puntaje
 *
 * The followings are the available model relations:
 * @property Evaluaciondesempeno $evaluacion0
 * @property Puntualizacion $puntualizacion0
 * @property Puntaje $puntaje0
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
			array('evaluacion, puntualizacion, escala, puntaje', 'numerical', 'integerOnly'=>true),
			array('compromiso', 'length', 'max'=>800),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, compromiso, evaluacion, puntualizacion, escala, puntaje', 'safe', 'on'=>'search'),
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
			'evaluacion0' => array(self::BELONGS_TO, 'Evaluaciondesempeno', 'evaluacion'),
			'puntualizacion0' => array(self::BELONGS_TO, 'Puntualizacion', 'puntualizacion'),
			'puntaje0' => array(self::BELONGS_TO, 'Puntaje', 'puntaje'),
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
		$criteria->compare('compromiso',$this->compromiso,true);
		$criteria->compare('evaluacion',$this->evaluacion);
		$criteria->compare('puntualizacion',$this->puntualizacion);
		$criteria->compare('escala',$this->escala);
		$criteria->compare('puntaje',$this->puntaje);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}