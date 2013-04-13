<?php

/**
 * This is the model class for table "meritoevaluacioncandidato".
 *
 * The followings are the available columns in table 'meritoevaluacioncandidato':
 * @property integer $id
 * @property integer $evaluacioncandidato
 * @property integer $merito
 * @property integer $calificacion
 * @property integer $ponderacion
 * @property string $comentario
 *
 * The followings are the available model relations:
 * @property Evaluacioncompetencias $_evaluacioncandidato
 * @property Merito $_merito
 */
class Meritoevaluacioncandidato extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Meritoevaluacioncandidato the static model class
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
		return 'meritoevaluacioncandidato';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('evaluacioncandidato, merito, calificacion, ponderacion', 'required'),
			array('evaluacioncandidato, merito, calificacion, ponderacion', 'numerical', 'integerOnly'=>true),
                        array('comentario', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, evaluacioncandidato, merito, calificacion, ponderacion, comentario', 'safe', 'on'=>'search'),
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
			'_evaluacioncandidato' => array(self::BELONGS_TO, 'Evaluacioncompetencias', 'evaluacioncandidato'),
			'_merito' => array(self::BELONGS_TO, 'Merito', 'merito'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'evaluacioncandidato' => 'Evaluacioncandidato',
			'merito' => 'Merito',
			'calificacion' => 'Calificacion',
                        'ponderacion' => 'Ponderacion',
			'comentario' => 'Comentario',
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
		$criteria->compare('evaluacioncandidato',$this->evaluacioncandidato);
		$criteria->compare('merito',$this->merito);
		$criteria->compare('calificacion',$this->calificacion);
                $criteria->compare('ponderacion',$this->ponderacion);
		$criteria->compare('comentario',$this->comentario,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}