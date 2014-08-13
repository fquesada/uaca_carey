<?php

/**
 * This is the model class for table "vacante".
 *
 * The followings are the available columns in table 'vacante':
 * @property integer $id
 * @property integer $periodo
 * @property string $fechareclutamiento
 * @property string $fechaseleccion
 * @property integer $procesoevaluacion
 * @property integer $puesto
 *
 * The followings are the available model relations:
 * @property Procesoevaluacion $procesoevaluacion0
 * @property Periodo $periodo0
 * @property Puesto $puesto0
 */
class Vacante extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vacante';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodo, procesoevaluacion, puesto', 'numerical', 'integerOnly'=>true),
			array('fechareclutamiento, fechaseleccion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, periodo, fechareclutamiento, fechaseleccion, procesoevaluacion, puesto', 'safe', 'on'=>'search'),
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
			'procesoevaluacion0' => array(self::BELONGS_TO, 'Procesoevaluacion', 'procesoevaluacion'),
			'_periodo' => array(self::BELONGS_TO, 'Periodo', 'periodo'),
			'_puesto' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'periodo' => 'Periodo',
			'fechareclutamiento' => 'Fechareclutamiento',
			'fechaseleccion' => 'Fechaseleccion',
			'procesoevaluacion' => 'Procesoevaluacion',
			'puesto' => 'Puesto',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('periodo',$this->periodo);
		$criteria->compare('fechareclutamiento',$this->fechareclutamiento,true);
		$criteria->compare('fechaseleccion',$this->fechaseleccion,true);
		$criteria->compare('procesoevaluacion',$this->procesoevaluacion);
		$criteria->compare('puesto',$this->puesto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vacante the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
