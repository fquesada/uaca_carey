<?php

/**
 * This is the model class for table "colaborador".
 *
 * The followings are the available columns in table 'colaborador':
 * @property integer $id
 * @property integer $cedula
 * @property string $nombre
 * @property string $apellido1
 * @property string $apellido2
 * @property integer $estado
 * @property integer $unidadnegocio
 * @property integer $puesto
 *
 * The followings are the available model relations:
 * @property Unidadnegociopuesto $unidadnegocio0
 * @property Unidadnegociopuesto $puesto0
 * @property Usuario[] $usuarios
 * @property Evaluacioncompetencias[] $evaluacioncompetenciases
 * @property Evaluaciondesempeno[] $evaluaciondesempenos
 * @property Evaluaciondesempeno[] $evaluaciondesempenos1
 * @property Evaluacionpersonas[] $evaluacionpersonases
 * @property Historicopuesto[] $historicopuestos
 */
class Colaborador extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Colaborador the static model class
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
		return 'colaborador';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cedula, nombre, apellido1, apellido2, unidadnegocio, puesto', 'required'),
			array('cedula, estado, unidadnegocio, puesto', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido1, apellido2', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cedula, nombre, apellido1, apellido2, estado, unidadnegocio, puesto', 'safe', 'on'=>'search'),
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
			'unidadnegocio0' => array(self::BELONGS_TO, 'Unidadnegociopuesto', 'unidadnegocio'),
			'puesto0' => array(self::BELONGS_TO, 'Unidadnegociopuesto', 'puesto'),
			'usuarios' => array(self::MANY_MANY, 'Usuario', 'colaboradorusuario(colaborador, usuario)'),
			'evaluacioncompetenciases' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'evaluador'),
			'evaluaciondesempenos' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'colaborador'),
			'evaluaciondesempenos1' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'evaluador'),
			'evaluacionpersonases' => array(self::HAS_MANY, 'Evaluacionpersonas', 'creador'),
			'historicopuestos' => array(self::HAS_MANY, 'Historicopuesto', 'colaborador'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cedula' => 'Cedula',
			'nombre' => 'Nombre',
			'apellido1' => 'Apellido1',
			'apellido2' => 'Apellido2',
			'estado' => 'Estado',
			'unidadnegocio' => 'Unidadnegocio',
			'puesto' => 'Puesto',
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
		$criteria->compare('cedula',$this->cedula);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido1',$this->apellido1,true);
		$criteria->compare('apellido2',$this->apellido2,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('unidadnegocio',$this->unidadnegocio);
		$criteria->compare('puesto',$this->puesto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}