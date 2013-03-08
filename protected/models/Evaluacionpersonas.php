<?php

/**
 * This is the model class for table "evaluacionpersonas".
 *
 * The followings are the available columns in table 'evaluacionpersonas':
 * @property integer $id
 * @property string $fecha
 * @property integer $creador
 * @property integer $estado
 * @property integer $puesto
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property Evaluacioncompetencias[] $_evaluacionescompetencias
 * @property Colaborador $_creador
 * @property Puesto $_puesto
 * @property Habilidadespecial[] $_habilidadesespecial
 * @property Habilidadespecialevaluada[] $_habilidadesespecialevaluada
 * @property Vacante[] $_vacantes
 */
class Evaluacionpersonas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluacionpersonas the static model class
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
		return 'evaluacionpersonas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, creador, puesto', 'required'),
			array('creador, estado, puesto', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>90),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, creador, estado, puesto, descripcion', 'safe', 'on'=>'search'),
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
			'_evaluacionescompetencias' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'evaluacionpersonas'),
			'_creador' => array(self::BELONGS_TO, 'Colaborador', 'creador'),
			'_puesto' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
			'_habilidadesespecial' => array(self::HAS_MANY, 'Habilidadespecial', 'evaluacionpersonas'),
			'_habilidadesespecialevaluada' => array(self::HAS_MANY, 'Habilidadespecialevaluada', 'evaluacionpersonas'),
			'_vacantes' => array(self::HAS_MANY, 'Vacante', 'evaluacionpersonas'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'creador' => 'Creador',
			'estado' => 'Estado',
			'puesto' => 'Puesto',
			'descripcion' => 'Descripcion',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('creador',$this->creador);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}