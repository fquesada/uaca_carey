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
 *
 * The followings are the available model relations:
 * @property Usuario[] $_usuarios
 * @property Evaluacioncompetencias[] $_evaluadoresevaluacioncompetencias
 * @property Evaluaciondesempeno[] $_colaboradoresevaluaciondesempeno
 * @property Evaluaciondesempeno[] $_evaluadoresevaluaciondesempeno
 * @property Evaluacionpersonas[] $_creadoresevaluacionpersonas
 * @property Historicopuesto[] $_colaboradoreshistoricopuesto
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
			array('cedula, nombre, apellido1, apellido2', 'required'),
			array('cedula, estado', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido1, apellido2', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cedula, nombre, apellido1, apellido2, estado', 'safe', 'on'=>'search'),
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
			'_usuarios' => array(self::MANY_MANY, 'Usuario', 'colaboradorusuario(colaborador, usuario)'),
			'_evaluadoresevaluacioncompetencias' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'evaluador'),
			'_colaboradoresevaluaciondesempeno' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'colaborador'),
			'_evaluadoresevaluaciondesempeno' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'evaluador'),
			'_creadoresevaluacionpersonas' => array(self::HAS_MANY, 'Evaluacionpersonas', 'creador'),
			'_colaboradoreshistoricopuesto' => array(self::HAS_MANY, 'Historicopuesto', 'colaborador'),
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
        
        /*
        * @param $terminobuscar es el keyword para buscar en el like del nombre
        * @param $idpuesto id del puesto
        * @return $array con cedula, nombre, apellido1, apellido2, idcolaborador. Si el array es vacio retorna false.
        */
        public function obtenercolaboradoresporpuesto($terminobuscar, $idpuesto){
            $connection=Yii::app()->db;
            $sql=   'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id
                    FROM colaborador c   
                    INNER JOIN historicopuesto hp ON c.id = hp.colaborador
                    WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like :terminobuscar
                    AND c.estado = 1
                    AND hp.puestoactual = 1
                    AND hp.puesto = :idpuesto;'; 
            $command=$connection->createCommand($sql);
            $terminobuscar = '%'.$terminobuscar.'%';//Para habilitar la busqueda por LIKE
            $command->bindParam("terminobuscar", $terminobuscar, PDO::PARAM_STR);
            $command->bindParam(":idpuesto", $idpuesto, PDO::PARAM_INT);
            $models = $command->queryAll();
          
            if (empty($models))
                return false;
            else 
                return $models;
        }
}

