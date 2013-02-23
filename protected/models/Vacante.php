<?php

/**
 * This is the model class for table "vacante".
 *
 * The followings are the available columns in table 'vacante':
 * @property integer $id
 * @property integer $unidadnegocio
 * @property integer $puesto
 * @property integer $periodo
 * @property string $fechareclutamiento
 * @property string $fechaseleccion
 *
 * The followings are the available model relations:
 * @property Entrevista[] $_entrevistas
 * @property Unidadnegociopuesto $_puesto
 * @property Unidadnegociopuesto $_unidadnegocio
 * @property Periodo $_periodo
 */
class Vacante extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vacante the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getNombreVacante()
        {
            $nombrepuesto = Puesto::model()->findByPk($this->puesto)->nombre;
            $nombreunidadnegocio = UnidadNegocio::model()->findByPk($this->unidadnegocio)->nombre;
            
            return $nombreunidadnegocio . " - " . $nombrepuesto;
        }

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
			array('unidadnegocio, puesto, periodo', 'required'),
			array('unidadnegocio, puesto, periodo', 'numerical', 'integerOnly'=>true),
			array('fechareclutamiento, fechaseleccion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, unidadnegocio, puesto, periodo, fechareclutamiento, fechaseleccion', 'safe', 'on'=>'search'),
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
			'_entrevistas' => array(self::HAS_MANY, 'Entrevista', 'vacante'),
			'_puesto' => array(self::BELONGS_TO, 'Unidadnegociopuesto', 'puesto'),
			'_unidadnegocio' => array(self::BELONGS_TO, 'Unidadnegociopuesto', 'unidadnegocio'),
			'_periodo' => array(self::BELONGS_TO, 'Periodo', 'periodo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'unidadnegocio' => 'Unidad de Negocio',
			'puesto' => 'Puesto',
			'periodo' => 'Periodo',
			'fechareclutamiento' => 'Fecha de Reclutamiento',
			'fechaseleccion' => 'Fecha de Selección',
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
		$criteria->compare('unidadnegocio',$this->unidadnegocio);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('periodo',$this->periodo);
		$criteria->compare('fechareclutamiento',$this->fechareclutamiento,true);
		$criteria->compare('fechaseleccion',$this->fechaseleccion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
