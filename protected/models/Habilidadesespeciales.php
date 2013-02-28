<?php

/**
 * This is the model class for table "habilidadesespeciales".
 *
 * The followings are the available columns in table 'habilidadesespeciales':
 * @property integer $id
 * @property integer $evaluacioncompetencias
 * @property string $nombre
 * @property string $descripcion
 * @property integer $calificacion
 * @property integer $ponderacion
 *
 * The followings are the available model relations:
 * @property Evaluacioncompetencias $_evaluacionescompetencias
 */
class Habilidadesespeciales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Habilidadesespeciales the static model class
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
		return 'habilidadesespeciales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evaluacioncompetencias, nombre, descripcion', 'required'),
			array('evaluacioncompetencias, calificacion, ponderacion', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>180),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, evaluacioncompetencias, nombre, descripcion, calificacion, ponderacion', 'safe', 'on'=>'search'),
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
			'_evaluacionescompetencias' => array(self::BELONGS_TO, 'Evaluacioncompetencias', 'evaluacioncompetencias'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'evaluacioncompetencias' => 'Evaluacioncompetencias',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
			'calificacion' => 'Calificacion',
			'ponderacion' => 'Ponderacion',
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
		$criteria->compare('evaluacioncompetencias',$this->evaluacioncompetencias);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('calificacion',$this->calificacion);
		$criteria->compare('ponderacion',$this->ponderacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}