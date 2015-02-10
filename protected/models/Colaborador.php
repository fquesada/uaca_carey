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
			'cedula' => 'Cédula',
			'nombre' => 'Nombre',
			'apellido1' => 'Primer Apellido',
			'apellido2' => 'Segundo Apellido',
			'estado' => 'Estado',	
                        'correo' => 'Correo',
                        'nombrepuestoactual'=>'Puesto',
                        'nombreunidadnegocioactual'=>'Unidad de Negocio',
                        'nombrecompleto'=>'Nombre Completo'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($condicion)
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
                
                if($condicion){
                    $criteria->addColumnCondition(array('estado'=>'1'));
                }
                else
                    $criteria->addColumnCondition(array('estado'=>'0'));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getEstadoColaborador(){
            if($this->estado == 1)        
                return "Activo";
            else
                return "Inactivo";
        }
        
        public function getnombrecompleto(){            
            if(isset($this->_nombrecompleto)) {
                return $this->_nombrecompleto;
            }            
            $this->_nombrecompleto = $this->nombre." ".$this->apellido1." ".$this->apellido2;
            return $this->_nombrecompleto;            
        }
        
        public function getregistrohistoricoactual($idcolaborador){
            $historicopuesto = Historicopuesto::model()->findByAttributes(array('colaborador' => $colaborador), 'puestoactual=1');
            return $historicopuesto;
        }
        
        public function getidpuestoactual(){
            $historicopuesto = Historicopuesto::model()->findByAttributes(array('colaborador' => $this->id), 'puestoactual=1');
            if(!is_null($historicopuesto))
                return $historicopuesto->puesto;
            else
                return false;
        }
        
        public function getnombrepuestoactual(){
            $historicopuesto = Historicopuesto::model()->findByAttributes(array('colaborador' => $this->id), 'puestoactual=1');
            if(is_null($historicopuesto))
                return false;
            $idpuesto = $historicopuesto->puesto;
            $puesto = Puesto::model()->findByPk($idpuesto);
            if(is_null($puesto))
                return false;
             else           
                return $puesto->nombre;
        }
        
        public function getnombreunidadnegocioactual(){
            $historicopuesto = Historicopuesto::model()->findByAttributes(array('colaborador' => $this->id), 'puestoactual=1');
            if(is_null($historicopuesto))
                return false;
            $idunidadnegocio = $historicopuesto->unidadnegocio;
            $unidadnegocio = Unidadnegocio::model()->findByPk($idunidadnegocio);
            if(is_null($unidadnegocio))
                return false;
             else           
                return $unidadnegocio->nombre;
        }
        
        public function add($idunidadnegocio){
            $criteria = new CDbCriteria;
            
            $criteria->compare('nombre',$this->nombre,true);
            $criteria->compare('codigo',$this->codigo,true);	
            
            $criteria->addcolumncondition(array('estado'=>'1'));
            
            $unidadpuesto = UnidadNegocioPuesto::model()->findAllByAttributes(array('unidadnegocio' => $idunidadnegocio));
            
            $existentes = $this->obtenerArrayColumna($unidadpuesto,'puesto');
            
            $criteria->addNotInCondition('id', $existentes);
                        
            return new CActiveDataProvider($this, array(
			//'keyAttribute'=>'id',
                        'criteria'=>$criteria             
		));
        }        
        
        public function BuscarColaborador($keyword, $activo = true){
            
            if($activo){
                $dataReader = Yii::app()->db->createCommand(
                               'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" ' .
                               'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id ' .
                               'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%' . $keyword . '%" AND c.estado = 1;'
                )->query();
            }
            else{
                $dataReader = Yii::app()->db->createCommand(
                               'SELECT c.cedula,c.nombre,c.apellido1,c.apellido2, c.id, p.nombre as "puesto" ' .
                               'FROM colaborador c INNER JOIN historicopuesto hp on c.id = hp.colaborador and hp.puestoactual = 1 INNER JOIN puesto p  ON hp.puesto = p.id ' .
                               'WHERE CONCAT_WS(" ", c.nombre, c.apellido1, c.apellido2 ) like "%' . $keyword . '%";'
                )->query();
            }
            return $dataReader;

        }
        
        public function HistoricoEvaluacion($idcolaborador){
            
        $connection = Yii::app()->db;
        $sql = 'SELECT p.nombre AS "Puesto", "EC" AS "TipoEvaluacion", 
                (SELECT CONCAT_WS(" ",ev.nombre, ev.apellido1,ev.apellido2) FROM colaborador ev WHERE ev.id = pe.evaluador) AS "Evaluador",
                ec.promedioponderado as "Calificacion", ec.id AS "IDEvaluacion", ec.fechaevaluacion AS "FechaEvaluacion"
                FROM colaborador c INNER JOIN evaluacioncompetencias ec ON c.id = ec.colaborador                
                INNER JOIN puesto p  ON ec.puesto = p.id                               
                INNER JOIN procesoevaluacion pe ON ec.procesoevaluacion = pe.id
                WHERE c.id = :idcolaborador and ec.estado = 2 and pe.estado <> 0
                UNION
                SELECT p.nombre AS "Puesto", "ED" AS "TipoEvaluacion", 
                (SELECT CONCAT_WS(" ",ev.nombre, ev.apellido1,ev.apellido2) FROM colaborador ev WHERE ev.id = pe.evaluador) AS "Evaluador",
                ed.promedioevaluacion as "Calificacion", ed.id AS "IDEvaluacion",  ed.fecharegistroevaluacion AS "FechaEvaluacion"
                FROM colaborador c INNER JOIN evaluaciondesempeno ed on c.id = ed.colaborador 
                INNER JOIN puesto p  ON ed.puesto = p.id                
                INNER JOIN procesoevaluacion pe ON ed.procesoevaluacion = pe.id
                WHERE c.id = :idcolaborador and ed.estadoevaluacion = 2 and ed.estado = 1 and pe.estado <> 0
                ORDER BY FechaEvaluacion
                ';
        $command = $connection->createCommand($sql);
        $command->bindParam(":idcolaborador", $idcolaborador, PDO::PARAM_INT);
        $dataReader = $command->queryAll();

        if (empty($dataReader))
            return false;
        else{
            foreach ($dataReader as &$fila) {
                $fecha = $fila["FechaEvaluacion"];
                $fila["FechaEvaluacion"] = CommonFunctions::datemysqltophp($fecha);
            }            
            return $dataReader;
        }
        }
}

