<?php

/**
 * This is the model class for table "habilidadespecial".
 *
 * The followings are the available columns in table 'habilidadespecial':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $procesoevaluacion
 * @property integer $ponderacion
 *
 * The followings are the available model relations:
 * @property Procesoevaluacion $_procesoevaluacion
 * @property Habilidadespecialevaluada[] $_habilidadesespecialevaluada
 */
class Habilidadespecial extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Habilidadespecial the static model class
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
		return 'habilidadespecial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, descripcion, procesoevaluacion, ponderacion', 'required'),
			array('procesoevaluacion, ponderacion', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>180),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, procesoevaluacion, ponderacion', 'safe', 'on'=>'search'),
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
			'_procesoevaluacion' => array(self::BELONGS_TO, 'Procesoevaluacion', 'procesoevaluacion'),
			'_habilidadesespecialevaluada' => array(self::HAS_MANY, 'Habilidadespecialevaluada', 'habilidadespecial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
			'procesoevaluacion' => 'Procesoevaluacion',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('procesoevaluacion',$this->procesoevaluacion);
                $criteria->compare('ponderacion',$this->ponderacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}