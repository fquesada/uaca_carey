<?php

/**
 * This is the model class for table "evaluacioncompetencias".
 *
 * The followings are the available columns in table 'evaluacioncompetencias':
 * @property integer $id
 * @property integer $evaluacionpersonas
 * @property string $fechaevaluacion
 * @property integer $frecuencia
 * @property integer $puestopotencial1
 * @property integer $puestopotencial2
 * @property integer $puestopotencial3
 * @property double $promedioponderado
 * @property integer $tipo
 * @property integer $evaluador
 * @property integer $evaluado
 *
 * The followings are the available model relations:
 * @property Puesto $puestopotencial10
 * @property Puesto $puestopotencial20
 * @property Puesto $puestopotencial30
 * @property Evaluacionpersonas $evaluacionpersonas0
 * @property Colaborador $evaluador0
 * @property Habilidadespecialevaluada[] $habilidadespecialevaluadas
 * @property Habilidadevaluacioncandidato[] $habilidadevaluacioncandidatos
 * @property Habilidadnoequivalente[] $habilidadnoequivalentes
 * @property Meritoevaluacioncandidato[] $meritoevaluacioncandidatos
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
			array('evaluacionpersonas, fechaevaluacion', 'required'),
			array('evaluacionpersonas, frecuencia, puestopotencial1, puestopotencial2, puestopotencial3, tipo, evaluador, evaluado', 'numerical', 'integerOnly'=>true),
			array('promedioponderado', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, evaluacionpersonas, fechaevaluacion, frecuencia, puestopotencial1, puestopotencial2, puestopotencial3, promedioponderado, tipo, evaluador, evaluado', 'safe', 'on'=>'search'),
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
			'puestopotencial10' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial1'),
			'puestopotencial20' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial2'),
			'puestopotencial30' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial3'),
			'evaluacionpersonas0' => array(self::BELONGS_TO, 'Evaluacionpersonas', 'evaluacionpersonas'),
			'evaluador0' => array(self::BELONGS_TO, 'Colaborador', 'evaluador'),
			'habilidadespecialevaluadas' => array(self::HAS_MANY, 'Habilidadespecialevaluada', 'evaluacioncompetencias'),
			'habilidadevaluacioncandidatos' => array(self::HAS_MANY, 'Habilidadevaluacioncandidato', 'evaluacioncandidato'),
			'habilidadnoequivalentes' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'evaluacioncandidato'),
			'meritoevaluacioncandidatos' => array(self::HAS_MANY, 'Meritoevaluacioncandidato', 'evaluacioncandidato'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'evaluacionpersonas' => 'Evaluacionpersonas',
			'fechaevaluacion' => 'Fechaevaluacion',
			'frecuencia' => 'Frecuencia',
			'puestopotencial1' => 'Puestopotencial1',
			'puestopotencial2' => 'Puestopotencial2',
			'puestopotencial3' => 'Puestopotencial3',
			'promedioponderado' => 'Promedioponderado',
			'tipo' => 'Tipo',
			'evaluador' => 'Evaluador',
			'evaluado' => 'Evaluado',
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
		$criteria->compare('evaluacionpersonas',$this->evaluacionpersonas);
		$criteria->compare('fechaevaluacion',$this->fechaevaluacion,true);
		$criteria->compare('frecuencia',$this->frecuencia);
		$criteria->compare('puestopotencial1',$this->puestopotencial1);
		$criteria->compare('puestopotencial2',$this->puestopotencial2);
		$criteria->compare('puestopotencial3',$this->puestopotencial3);
		$criteria->compare('promedioponderado',$this->promedioponderado);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('evaluador',$this->evaluador);
		$criteria->compare('evaluado',$this->evaluado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}