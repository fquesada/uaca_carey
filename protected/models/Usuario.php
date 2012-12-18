<?php

/**
 * This is the model class for table "Usuario".
 *
 * The followings are the available columns in table 'Usuario':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $fechacreacion
 * @property string $nombre
 * @property string $apellido1
 * @property string $apellido2
 * @property string $activo
 * @property integer $empresa
 *
 * The followings are the available model relations:
 * @property Empresa[] $empresas
 * @property Empresa $empresa0
 */
class Usuario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuario the static model class
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
		return 'Usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, fechacreacion, nombre, apellido1, apellido2', 'required'),
			array('empresa', 'numerical', 'integerOnly'=>true),
			array('login, password, nombre, apellido1, apellido2', 'length', 'max'=>45),
			array('activo', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, password, fechacreacion, nombre, apellido1, apellido2, activo, empresa', 'safe', 'on'=>'search'),
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
			'empresas' => array(self::HAS_MANY, 'Empresa', 'usuarioadmin'),
			'empresa0' => array(self::BELONGS_TO, 'Empresa', 'empresa'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'password' => 'Password',
			'fechacreacion' => 'Fechacreacion',
			'nombre' => 'Nombre',
			'apellido1' => 'Apellido1',
			'apellido2' => 'Apellido2',
			'activo' => 'Activo',
			'empresa' => 'Empresa',
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
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido1',$this->apellido1,true);
		$criteria->compare('apellido2',$this->apellido2,true);
		$criteria->compare('activo',$this->activo,true);
		$criteria->compare('empresa',$this->empresa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}