<?php

/**
 * This is the model class for table "empresa".
 *
 * The followings are the available columns in table 'empresa':
 * @property integer $id
 * @property string $nombre
 * @property string $detalle
 * @property string $contacto
 * @property string $logo
 * @property string $fechaingreso
 * @property integer $usuarioedicion
 * @property string $fechamodificacion
 * @property integer $usuarioadmin
 * @property string $cedulajuridica
 * @property string $activo
 *
 * The followings are the available model relations:
 * @property Colaborador[] $colaboradors
 * @property Usuario $usuarioadmin0
 * @property Unidadnegocio[] $unidadnegocios
 * @property Usuario[] $usuarios
 */
class Empresa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Empresa the static model class
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
		return 'empresa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, fechaingreso, usuarioedicion, fechamodificacion, usuarioadmin', 'required'),
			array('usuarioedicion, usuarioadmin', 'numerical', 'integerOnly'=>true),
			array('nombre, contacto, cedulajuridica', 'length', 'max'=>100),
			array('detalle', 'length', 'max'=>200),
			array('activo', 'length', 'max'=>1),
			array('logo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, detalle, contacto, logo, fechaingreso, usuarioedicion, fechamodificacion, usuarioadmin, cedulajuridica, activo', 'safe', 'on'=>'search'),
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
			'colaboradors' => array(self::HAS_MANY, 'Colaborador', 'empresa'),
			'usuarioadmin0' => array(self::BELONGS_TO, 'Usuario', 'usuarioadmin'),
			'unidadnegocios' => array(self::HAS_MANY, 'Unidadnegocio', 'empresa'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'empresa'),
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
			'detalle' => 'Detalle',
			'contacto' => 'Contacto',
			'logo' => 'Logo',
			'fechaingreso' => 'Fechaingreso',
			'usuarioedicion' => 'Usuarioedicion',
			'fechamodificacion' => 'Fechamodificacion',
			'usuarioadmin' => 'Usuarioadmin',
			'cedulajuridica' => 'Cedulajuridica',
			'activo' => 'Activo',
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
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('contacto',$this->contacto,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('fechaingreso',$this->fechaingreso,true);
		$criteria->compare('usuarioedicion',$this->usuarioedicion);
		$criteria->compare('fechamodificacion',$this->fechamodificacion,true);
		$criteria->compare('usuarioadmin',$this->usuarioadmin);
		$criteria->compare('cedulajuridica',$this->cedulajuridica,true);
		$criteria->compare('activo',$this->activo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}