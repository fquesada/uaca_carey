<?php

/**
 * This is the model class for table "puesto".
 *
 * The followings are the available columns in table 'puesto':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $codigo
 * @property string $funciones
 * @property integer $unidadnegocio
 * @property string $activo
 *
 * The followings are the available model relations:
 * @property Colaborador[] $colaboradors
 * @property Evaluacion[] $evaluacions
 * @property Historicopuesto[] $historicopuestos
 * @property Unidadnegocio $unidadnegocio0
 * @property Competencia[] $competencias
 * @property Puntualizacion[] $puntualizacions
 */
class Puesto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Puesto the static model class
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
		return 'puesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, codigo, unidadnegocio', 'required'),
			array('unidadnegocio', 'numerical', 'integerOnly'=>true),
			array('nombre, codigo', 'length', 'max'=>45),
			array('activo', 'length', 'max'=>1),
			array('descripcion, funciones', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, codigo, funciones, unidadnegocio, activo', 'safe', 'on'=>'search'),
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
			'colaboradors' => array(self::HAS_MANY, 'Colaborador', 'puesto'),
			'evaluacions' => array(self::HAS_MANY, 'Evaluacion', 'puesto'),
			'historicopuestos' => array(self::HAS_MANY, 'Historicopuesto', 'puesto'),
			'unidadnegocio0' => array(self::BELONGS_TO, 'Unidadnegocio', 'unidadnegocio'),
			'competencias' => array(self::MANY_MANY, 'Competencia', 'puestocompetencia(puesto, competencia)'),
			'puntualizacions' => array(self::MANY_MANY, 'Puntualizacion', 'puestopuntualizacion(puesto, puntualizacion)'),
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
			'codigo' => 'Codigo',
			'funciones' => 'Funciones',
			'unidadnegocio' => 'Unidadnegocio',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('funciones',$this->funciones,true);
		$criteria->compare('unidadnegocio',$this->unidadnegocio);
		$criteria->compare('activo',$this->activo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}