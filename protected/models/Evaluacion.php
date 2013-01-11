<?php

/**
 * This is the model class for table "evaluacion".
 *
 * The followings are the available columns in table 'evaluacion':
 * @property integer $id
 * @property integer $evaluador
 * @property string $fechaevaluacion
 * @property string $fecharegistro
 * @property string $estadoevaluacion
 * @property integer $colaborador
 * @property string $comentario
 * @property integer $puesto
 * @property integer $periodo
 *
 * The followings are the available model relations:
 * @property Compromiso[] $compromisos
 * @property Colaborador $colaborador0
 * @property Colaborador $evaluador0
 * @property Periodo $periodo0
 * @property Puesto $puesto0
 * @property Itemcompetencia[] $itemcompetencias
 */
class Evaluacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluacion the static model class
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
		return 'evaluacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evaluador, fechaevaluacion, fecharegistro, colaborador, puesto, periodo', 'required'),
			array('evaluador, colaborador, puesto, periodo', 'numerical', 'integerOnly'=>true),
			array('estadoevaluacion', 'length', 'max'=>1),
			array('comentario', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, evaluador, fechaevaluacion, fecharegistro, estadoevaluacion, colaborador, comentario, puesto, periodo', 'safe', 'on'=>'search'),
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
			'compromisos' => array(self::HAS_MANY, 'Compromiso', 'evaluacion'),
			'colaborador0' => array(self::BELONGS_TO, 'Colaborador', 'colaborador'),
			'evaluador0' => array(self::BELONGS_TO, 'Colaborador', 'evaluador'),
			'periodo0' => array(self::BELONGS_TO, 'Periodo', 'periodo'),
			'puesto0' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
			'itemcompetencias' => array(self::HAS_MANY, 'Itemcompetencia', 'evaluacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'evaluador' => 'Evaluador',
			'fechaevaluacion' => 'Fechaevaluacion',
			'fecharegistro' => 'Fecharegistro',
			'estadoevaluacion' => 'Estadoevaluacion',
			'colaborador' => 'Colaborador',
			'comentario' => 'Comentario',
			'puesto' => 'Puesto',
			'periodo' => 'Periodo',
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
		$criteria->compare('evaluador',$this->evaluador);
		$criteria->compare('fechaevaluacion',$this->fechaevaluacion,true);
		$criteria->compare('fecharegistro',$this->fecharegistro,true);
		$criteria->compare('estadoevaluacion',$this->estadoevaluacion,true);
		$criteria->compare('colaborador',$this->colaborador);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('periodo',$this->periodo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}