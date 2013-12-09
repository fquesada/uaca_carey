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
 * @property string $correo
 *
 * The followings are the available model relations:
 * @property Evaluacioncompetencias[] $_colaboradorevaluacioncompetencias
 * @property Evaluaciondesempeno[] $_colaboradoresevaluaciondesempeno
 * @property Historicopuesto[] $_colaboradoreshistoricopuesto
 * @property Procesoevaluacion[] $_evaluadorprocesoevaluacion
 */
class Colaborador extends CActiveRecord
{
    
        private $_nombrecompleto;
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
			array('cedula, nombre, apellido1, apellido2, correo', 'required'),
			array('cedula, estado', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido1, apellido2', 'length', 'max'=>45),
                        array('correo', 'length', 'max'=>90),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cedula, nombre, apellido1, apellido2, correo, estado', 'safe', 'on'=>'search'),
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
                        '_colaboradorevaluacioncompetencias' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'colaborador'),
			'_colaboradoresevaluaciondesempeno' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'colaborador'),		
			'_colaboradoreshistoricopuesto' => array(self::HAS_MANY, 'Historicopuesto', 'colaborador'),
                        '_evaluadorprocesoevaluacion' => array(self::HAS_MANY, 'Procesoevaluacion', 'evaluador'),
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
			'apellido1' => 'Primer Apellido',
			'apellido2' => 'Segundo Apellido',
			'estado' => 'Estado',	
                        'correo' => 'Correo',
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
                $criteria->compare('correo',$this->correo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        //Posiblemente esta funcion ya no sirva
       public function getNombreUnidadNegocio(){
            $unidadsel = Unidadnegocio::model()->findAllByAttributes(array('id'=>$this->unidadnegocio));
            foreach ($unidadsel as $unidadnegocio){
                $resultado = $unidadnegocio->nombre;
            }
            return $resultado;
        }
        
        //Posiblemente esta funcion ya no sirva
        public function getNombrePuesto(){
            $puestosel = Puesto::model()->findAllByAttributes(array('id'=>$this->puesto));
            foreach ($puestosel as $puesto){
                $resultado = $puesto->nombre;
            }
            return $resultado;
        }
        
        public function getnombrecompleto(){            
            if(isset($this->_nombrecompleto)) {
                return $this->_nombrecompleto;
            }            
            $this->_nombrecompleto = $this->nombre." ".$this->apellido1." ".$this->apellido2;
            return $this->_nombrecompleto;            
        }
}

