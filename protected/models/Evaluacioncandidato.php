<?php

/**
 * This is the model class for table "evaluacioncandidato".
 *
 * The followings are the available columns in table 'evaluacioncandidato':
 * @property integer $id
 * @property integer $entrevista
 * @property string $fechaevaluacion
 * @property integer $origenevaluacion
 * @property integer $frecuencia
 * @property integer $puestopotencial1
 * @property integer $puestopotencial2
 * @property integer $puestopotencial3
 * @property double $promedioponderado
 *
 * The followings are the available model relations:
 * @property Entrevista $_entrevista
 * @property Puesto $_puestopotencial1
 * @property Puesto $_puestopotencial2
 * @property Puesto $_puestopotencial3
 * @property Habilidadevaluacioncandidato[] $_habilidadevaluacioncandidatos
 * @property Habilidadnoequivalente[] $_habilidadnoequivalentes
 * @property Meritoevaluacioncandidato[] $_meritoevaluacioncandidatos
 */
class Evaluacioncandidato extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluacioncandidato the static model class
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
		return 'evaluacioncandidato';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entrevista, fechaevaluacion, origenevaluacion', 'required'),
			array('entrevista, origenevaluacion, frecuencia, puestopotencial1, puestopotencial2, puestopotencial3', 'numerical', 'integerOnly'=>true),
			array('promedioponderado', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, entrevista, fechaevaluacion, origenevaluacion, frecuencia, puestopotencial1, puestopotencial2, puestopotencial3, promedioponderado', 'safe', 'on'=>'search'),
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
			'_entrevista' => array(self::BELONGS_TO, 'Entrevista', 'entrevista'),
			'_puestopotencial1' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial1'),
			'_puestopotencial2' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial2'),
			'_puestopotencial3' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial3'),
			'_habilidadevaluacioncandidatos' => array(self::HAS_MANY, 'Habilidadevaluacioncandidato', 'evaluacioncandidato'),
			'_habilidadnoequivalentes' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'evaluacioncandidato'),
			'_meritoevaluacioncandidatos' => array(self::HAS_MANY, 'Meritoevaluacioncandidato', 'evaluacioncandidato'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'entrevista' => 'Entrevista',
			'fechaevaluacion' => 'Fechaevaluacion',
			'origenevaluacion' => 'Origenevaluacion',
			'frecuencia' => 'Frecuencia',
			'puestopotencial1' => 'Puestopotencial1',
			'puestopotencial2' => 'Puestopotencial2',
			'puestopotencial3' => 'Puestopotencial3',
			'promedioponderado' => 'Promedioponderado',
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
		$criteria->compare('entrevista',$this->entrevista);
		$criteria->compare('fechaevaluacion',$this->fechaevaluacion,true);
		$criteria->compare('origenevaluacion',$this->origenevaluacion);
		$criteria->compare('frecuencia',$this->frecuencia);
		$criteria->compare('puestopotencial1',$this->puestopotencial1);
		$criteria->compare('puestopotencial2',$this->puestopotencial2);
		$criteria->compare('puestopotencial3',$this->puestopotencial3);
		$criteria->compare('promedioponderado',$this->promedioponderado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}