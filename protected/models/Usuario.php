<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $fechacreacion
 * @property string $nombre
 * @property string $apellido1
 * @property string $apellido2
 * @property integer $estado
 * @property integer $empresa
 * @property integer $tipousuario
 *
 * The followings are the available model relations:
 * @property Empresa $empresa0
 * @property Tipousuario $tipousuario0
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
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, fechacreacion, nombre, apellido1, apellido2, empresa, tipousuario', 'required'),
			array('estado, empresa, tipousuario', 'numerical', 'integerOnly'=>true),
			array('login, password, nombre, apellido1, apellido2', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, password, fechacreacion, nombre, apellido1, apellido2, estado, empresa, tipousuario', 'safe', 'on'=>'search'),
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
			'_empresa' => array(self::BELONGS_TO, 'Empresa', 'empresa'),
			'_tipousuario' => array(self::BELONGS_TO, 'Tipousuario', 'tipousuario'),
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
			'estado' => 'Estado',
			'empresa' => 'Empresa',
			'tipousuario' => 'Tipousuario',
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
		$criteria->compare('estado',$this->estado);
		$criteria->compare('empresa',$this->empresa);
		$criteria->compare('tipousuario',$this->tipousuario);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}