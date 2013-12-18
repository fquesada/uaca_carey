<?php

/**
 * This is the model class for table "evaluaciondesempeno".
 *
 * The followings are the available columns in table 'evaluaciondesempeno':
 * @property integer $id
 * @property integer $colaborador
 * @property integer $puesto
 * @property string $fecharegistrocompromiso
 * @property string $fechaevaluacion
 * @property string $comentariocompromisos
 * @property string $comentarioevaluacion
 * @property double $promediocompromisos
 * @property double $promediocompetencias
 * @property double $promedioevaluacion
 * @property string $fecharegistroevaluacion
 * @property integer $estadoevaluacion
 * @property integer $links
 * @property integer $procesoevaluacion
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Compromiso[] $_compromisos
 * @property Calificacioncompetencia[] $_calificacioncompetencias
 * @property Colaborador $_colaborador
 * @property Links $_links
 * @property Puesto $_puesto
 * @property Procesoevaluacion $_procesoevaluacion
 */
class Evaluaciondesempeno extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluaciondesempeno the static model class
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
		return 'evaluaciondesempeno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('colaborador, puesto, fecharegistrocompromiso, fechaevaluacion, links, procesoevaluacion', 'required'),
			array('colaborador, puesto, estadoevaluacion, links, procesoevaluacion, estado', 'numerical', 'integerOnly'=>true),
			array('promediocompromisos, promediocompetencias, promedioevaluacion', 'numerical'),
			array('comentariocompromisos, comentarioevaluacion', 'length', 'max'=>800),
			array('fecharegistroevaluacion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, colaborador, puesto, fecharegistrocompromiso, fechaevaluacion, comentariocompromisos, comentarioevaluacion, promediocompromisos, promediocompetencias, promedioevaluacion, fecharegistroevaluacion, estadoevaluacion, links, procesoevaluacion, estado', 'safe', 'on'=>'search'),
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
			'_compromisos' => array(self::HAS_MANY, 'Compromiso', 'evaluacion'),
			'_calificacioncompetencias' => array(self::HAS_MANY, 'Calificacioncompetencia', 'evaluacion'),
			'_colaborador' => array(self::BELONGS_TO, 'Colaborador', 'colaborador'),			
			'_puesto' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
                        '_links' => array(self::BELONGS_TO, 'Links', 'links'),
                        '_procesoevaluacion' => array(self::BELONGS_TO, 'Procesoevaluacion', 'procesoevaluacion '),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',			
			'colaborador' => 'Colaborador',
			'puesto' => 'Puesto',
			'fecharegistrocompromiso' => 'Fecharegistrocompromiso',
			'fechaevaluacion' => 'Fechaevaluacion',			
			'comentariocompromisos' => 'Comentariocompromisos',
			'comentarioevaluacion' => 'Comentarioevaluacion',
			'promediocompromisos' => 'Promediocompromisos',
			'promediocompetencias' => 'Promediocompetencias',
			'promedioevaluacion' => 'Promedioevaluacion',
			'fecharegistroevaluacion' => 'Fecharegistroevaluacion',
			'estadoevaluacion' => 'Estadoevaluacion',
                        'links' => 'Links',
			'procesoevaluacion' => 'Procesoevaluacion',
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
		$criteria->compare('colaborador',$this->colaborador);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('fecharegistrocompromiso',$this->fecharegistrocompromiso,true);
		$criteria->compare('fechaevaluacion',$this->fechaevaluacion,true);
		$criteria->compare('comentariocompromisos',$this->comentariocompromisos,true);
		$criteria->compare('comentarioevaluacion',$this->comentarioevaluacion,true);
		$criteria->compare('promediocompromisos',$this->promediocompromisos);
		$criteria->compare('promediocompetencias',$this->promediocompetencias);
		$criteria->compare('promedioevaluacion',$this->promedioevaluacion);
		$criteria->compare('fecharegistroevaluacion',$this->fecharegistroevaluacion,true);
		$criteria->compare('estadoevaluacion',$this->estadoevaluacion);
                $criteria->compare('links',$this->links);
		$criteria->compare('procesoevaluacion',$this->procesoevaluacion);
                $criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}