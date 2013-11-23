<?php

/**
 * This is the model class for table "habilidadespecialevaluada".
 *
 * The followings are the available columns in table 'habilidadespecialevaluada':
 * @property integer $id
 * @property integer $habilidadespecial
 * @property integer $procesoevaluacion
 * @property integer $calificacion
 * @property integer $evaluacioncompetencias
 * @property string $comentario
 *
 * The followings are the available model relations:
 * @property Habilidadespecial $_habilidadespecial
 * @property Procesoevaluacion $_procesoevaluacion
 * @property Evaluacioncompetencias $_evaluacioncompetencias
 */
class Habilidadespecialevaluada extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Habilidadespecialevaluada the static model class
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
		return 'habilidadespecialevaluada';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('habilidadespecial, procesoevaluacion, calificacion, evaluacioncompetencias', 'required'),
			array('habilidadespecial, procesoevaluacion, calificacion, evaluacioncompetencias', 'numerical', 'integerOnly'=>true),
                        array('comentario', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, habilidadespecial, procesoevaluacion, calificacion, evaluacioncompetencias', 'safe', 'on'=>'search'),
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
			'_habilidadespecial' => array(self::BELONGS_TO, 'Habilidadespecial', 'habilidadespecial'),
			'_procesoevaluacion' => array(self::BELONGS_TO, 'Procesoevaluacion', 'procesoevaluacion'),
			'_evaluacioncompetencias' => array(self::BELONGS_TO, 'Evaluacioncompetencias', 'evaluacioncompetencias'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'habilidadespecial' => 'Habilidadespecial',
			'procesoevaluacion' => 'Procesoevaluacion',
			'calificacion' => 'Calificacion',
			'evaluacioncompetencias' => 'Evaluacioncompetencias',
                        'comentario' => 'Comentario',
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
		$criteria->compare('habilidadespecial',$this->habilidadespecial);
		$criteria->compare('procesoevaluacion',$this->procesoevaluacion);
		$criteria->compare('calificacion',$this->calificacion);
		$criteria->compare('evaluacioncompetencias',$this->evaluacioncompetencias);
                $criteria->compare('comentario',$this->comentario,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}