<?php

/**
 * This is the model class for table "habilidadevaluacioncandidato".
 *
 * The followings are the available columns in table 'habilidadevaluacioncandidato':
 * @property integer $id
 * @property integer $competencia
 * @property integer $evaluacioncandidato
 * @property string $variableequivalentemetodo
 * @property string $calificacionobtenidoenmetodo
 * @property integer $conversionescala
 *
 * The followings are the available model relations:
 * @property Competencia $_competencia
 * @property Evaluacioncandidato $_evaluacioncandidato
 */
class Habilidadevaluacioncandidato extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Habilidadevaluacioncandidato the static model class
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
		return 'habilidadevaluacioncandidato';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('competencia, evaluacioncandidato, variableequivalentemetodo, calificacionobtenidoenmetodo, conversionescala', 'required'),
			array('competencia, evaluacioncandidato, conversionescala', 'numerical', 'integerOnly'=>true),
			array('variableequivalentemetodo', 'length', 'max'=>90),
			array('calificacionobtenidoenmetodo', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, competencia, evaluacioncandidato, variableequivalentemetodo, calificacionobtenidoenmetodo, conversionescala', 'safe', 'on'=>'search'),
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
			'_evaluacioncandidato' => array(self::BELONGS_TO, 'Evaluacioncandidato', 'evaluacioncandidato'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'competencia' => 'Competencia',
			'evaluacioncandidato' => 'Evaluacioncandidato',
			'variableequivalentemetodo' => 'Variableequivalentemetodo',
			'calificacionobtenidoenmetodo' => 'Calificacionobtenidoenmetodo',
			'conversionescala' => 'Conversionescala',
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
		$criteria->compare('competencia',$this->competencia);
		$criteria->compare('evaluacioncandidato',$this->evaluacioncandidato);
		$criteria->compare('variableequivalentemetodo',$this->variableequivalentemetodo,true);
		$criteria->compare('calificacionobtenidoenmetodo',$this->calificacionobtenidoenmetodo,true);
		$criteria->compare('conversionescala',$this->conversionescala);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}