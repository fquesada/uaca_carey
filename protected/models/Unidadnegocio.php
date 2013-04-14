<?php

/**
 * This is the model class for table "unidadnegocio".
 *
 * The followings are the available columns in table 'unidadnegocio':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $empresa
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Historicopuesto[] $_historicopuestos
 * @property Empresa $_empresa
 * @property Puesto[] $_puestos
 * @property Vacante[] $_vacantes
 */
class Unidadnegocio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Unidadnegocio the static model class
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
		return 'unidadnegocio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('empresa, estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>90),
			array('descripcion', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, empresa, estado', 'safe', 'on'=>'search'),
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
                        '_historicopuestos' => array(self::HAS_MANY, 'Historicopuesto', 'unidadnegocio'),
			'_empresa' => array(self::BELONGS_TO, 'Empresa', 'empresa'),
			'_puestos' => array(self::MANY_MANY, 'Puesto', 'unidadnegociopuesto(unidadnegocio, puesto)'),
                        '_vacantes' => array(self::HAS_MANY, 'Vacante', 'unidadnegocio'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
			'empresa' => 'Empresa',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('empresa',$this->empresa);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}