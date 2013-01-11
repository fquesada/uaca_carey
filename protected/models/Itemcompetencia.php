<?php

/**
 * This is the model class for table "itemcompetencia".
 *
 * The followings are the available columns in table 'itemcompetencia':
 * @property integer $id
 * @property integer $evaluacion
 * @property integer $puntaje
 * @property integer $Competencia_id
 *
 * The followings are the available model relations:
 * @property Competencia $competencia
 * @property Evaluacion $evaluacion0
 * @property Puntaje $puntaje0
 */
class Itemcompetencia extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Itemcompetencia the static model class
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
		return 'itemcompetencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evaluacion, puntaje, Competencia_id', 'required'),
			array('evaluacion, puntaje, Competencia_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, evaluacion, puntaje, Competencia_id', 'safe', 'on'=>'search'),
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
			'competencia' => array(self::BELONGS_TO, 'Competencia', 'Competencia_id'),
			'evaluacion0' => array(self::BELONGS_TO, 'Evaluacion', 'evaluacion'),
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
			'evaluacion' => 'Evaluacion',
			'puntaje' => 'Puntaje',
			'Competencia_id' => 'Competencia',
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
		$criteria->compare('puntaje',$this->puntaje);
		$criteria->compare('Competencia_id',$this->Competencia_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}