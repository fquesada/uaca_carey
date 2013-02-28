<?php

/**
 * This is the model class for table "evaluacioncompetencias".
 *
 * The followings are the available columns in table 'evaluacioncompetencias':
 * @property integer $id
 * @property integer $entrevista
 * @property string $fechaevaluacion
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
 * @property Habilidadesespeciales[] $_habilidadesespeciales
 * @property Habilidadevaluacioncandidato[] $_habilidadevaluacioncandidatos
 * @property Habilidadnoequivalente[] $_habilidadnoequivalentes
 * @property Meritoevaluacioncandidato[] $_meritoevaluacioncandidatos
 * @property Origenevaluacioncompetencias[] $_origenevaluacioncompetenciases
 */
class Evaluacioncompetencias extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluacioncompetencias the static model class
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
		return 'evaluacioncompetencias';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entrevista, fechaevaluacion', 'required'),
			array('entrevista, frecuencia, puestopotencial1, puestopotencial2, puestopotencial3', 'numerical', 'integerOnly'=>true),
			array('promedioponderado', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, entrevista, fechaevaluacion, frecuencia, puestopotencial1, puestopotencial2, puestopotencial3, promedioponderado', 'safe', 'on'=>'search'),
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
			'_habilidadesespeciales' => array(self::HAS_MANY, 'Habilidadesespeciales', 'evaluacioncompetencias'),
			'_habilidadevaluacioncandidatos' => array(self::HAS_MANY, 'Habilidadevaluacioncandidato', 'evaluacioncandidato'),
			'_habilidadnoequivalentes' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'evaluacioncandidato'),
			'_meritoevaluacioncandidatos' => array(self::HAS_MANY, 'Meritoevaluacioncandidato', 'evaluacioncandidato'),
			'_origenevaluacioncompetenciases' => array(self::HAS_MANY, 'Origenevaluacioncompetencias', 'evaluacioncompetencias'),
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