<?php

/**
 * This is the model class for table "puesto".
 *
 * The followings are the available columns in table 'puesto':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $codigo
 * @property integer $unidadnegocio
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Colaborador[] $_colaboradores
 * @property Evaluaciondesempeno[] $_evaluacionesdesempeno
 * @property Historicopuesto[] $_historicopuestos
 * @property Meritos[] $_meritos
 * @property Unidadnegocio $_unidadnegocio
 * @property Competencia[] $_competencias
 * @property Puntualizacion[] $_puntualizaciones
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
			array('unidadnegocio, estado', 'numerical', 'integerOnly'=>true),
                        array('codigo','unique'),
			array('nombre, codigo', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, codigo, unidadnegocio, estado', 'safe', 'on'=>'search'),
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
			'_colaboradores' => array(self::HAS_MANY, 'Colaborador', 'puesto'),
			'_evaluacionesdesempeno' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'puesto'),
			'_historicopuestos' => array(self::HAS_MANY, 'Historicopuesto', 'puesto'),
			'_meritos' => array(self::HAS_MANY, 'Meritos', 'puesto'),
			'_unidadnegocio' => array(self::BELONGS_TO, 'Unidadnegocio', 'unidadnegocio'),
			'_competencias' => array(self::MANY_MANY, 'Competencia', 'puestocompetencia(puesto, competencia)'),
			'_puntualizaciones' => array(self::MANY_MANY, 'Puntualizacion', 'puestopuntualizacion(puesto, puntualizacion)'),
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
			'descripcion' => 'Descripción',
			'codigo' => 'Código',
			'unidadnegocio' => 'Unidad de negocio',
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
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('unidadnegocio',$this->unidadnegocio);
		$criteria->compare('estado',$this->estado);
                
                //Muestra los puestos activos unicamente
                $criteria->addcolumncondition(array('estado'=>'1'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'Pagination'=>array('pageSize'=>'10'),
		));
	}
}