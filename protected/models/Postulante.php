<?php

/**
 * This is the model class for table "postulante".
 *
 * The followings are the available columns in table 'postulante':
 * @property integer $id
 * @property integer $cedula
 * @property string $nombre
 * @property string $apellido1
 * @property string $apellido2
 * @property integer $estado
 */
class Postulante extends CActiveRecord
{
    private $_nombrecompleto;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Postulante the static model class
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
		return 'postulante';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cedula, nombre, apellido1, apellido2', 'required'),
			array('cedula, estado', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido1, apellido2', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cedula, nombre, apellido1, apellido2, estado', 'safe', 'on'=>'search'),
		);
	}

        public function getnombrecompleto(){            
           if(isset($this->_nombrecompleto)) {
               return $this->_nombrecompleto;
           }            
           $this->_nombrecompleto = $this->nombre." ".$this->apellido1." ".$this->apellido2;
           return $this->_nombrecompleto;            
       }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}