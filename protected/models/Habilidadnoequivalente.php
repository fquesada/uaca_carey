<?php

/**
 * This is the model class for table "habilidadnoequivalente".
 *
 * The followings are the available columns in table 'habilidadnoequivalente':
 * @property integer $id
 * @property string $metodo
 * @property integer $competencia
 * @property integer $evaluacioncandidato
 * @property integer $calificacion
 * @property integer $puestopotencial1
 * @property integer $puestopotencial2
 * @property string $variablemetodo
 *
 * The followings are the available model relations:
 * @property Competencia $_competencia
 * @property Puesto $_puestopotencial1
 * @property Evaluacioncompetencias $_evaluacioncandidato
 * @property Puesto $_puestopotencial2
 */
class Habilidadnoequivalente extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Habilidadnoequivalente the static model class
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
		return 'habilidadnoequivalente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('metodo, competencia, evaluacioncandidato, calificacion, variablemetodo', 'required'),
			array('competencia, evaluacioncandidato, calificacion, puestopotencial1, puestopotencial2', 'numerical', 'integerOnly'=>true),
			array('metodo, variablemetodo', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, metodo, competencia, evaluacioncandidato, calificacion, puestopotencial1, puestopotencial2, variablemetodo', 'safe', 'on'=>'search'),
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
			'_competencia' => array(self::BELONGS_TO, 'Competencia', 'competencia'),
			'_puestopotencial1' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial1'),
			'_evaluacioncandidato' => array(self::BELONGS_TO, 'Evaluacioncompetencias', 'evaluacioncandidato'),
			'_puestopotencial2' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial2'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'metodo' => 'metodo',
			'competencia' => 'Competencia',
			'evaluacioncandidato' => 'Evaluacioncandidato',
			'calificacion' => 'Calificacion',
			'puestopotencial1' => 'Puestopotencial1',
			'puestopotencial2' => 'Puestopotencial2',
                        'variablemetodo' => 'Variable Metodo',
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
		$criteria->compare('metodo',$this->metodo,true);
		$criteria->compare('competencia',$this->competencia);
		$criteria->compare('evaluacioncandidato',$this->evaluacioncandidato);
		$criteria->compare('calificacion',$this->calificacion);
		$criteria->compare('puestopotencial1',$this->puestopotencial1);
		$criteria->compare('puestopotencial2',$this->puestopotencial2);
                $criteria->compare('variablemetodo',$this->variablemetodo, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}