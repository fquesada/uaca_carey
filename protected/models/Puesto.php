<?php

/**
 * This is the model class for table "puesto".
 *
 * The followings are the available columns in table 'puesto':
 * @property integer $id
 * @property string $nombre
 * @property string $codigo
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Evaluacioncompetencias[] $_puestospotencial1evaluacioncompetencia
 * @property Evaluacioncompetencias[] $_puestospotencial2evaluacioncompetencia
 * @property Evaluacioncompetencias[] $_puestospotencial3evaluacioncompetencia
 * @property Evaluacioncompetencias[] $_puestoevaluacioncompetencias
 * @property Evaluaciondesempeno[] $$_puestosevaluaciondesempeno
 * @property Habilidadnoequivalente[] $_puestospotencial1habilidadnoequivalente
 * @property Habilidadnoequivalente[] $_puestospotencial2habilidadnoequivalente
 * @property Habilidadnoequivalente[] $_puestospotencial3habilidadnoequivalente
 * @property Historicopuesto[] $_historicopuestos
 * @property Merito[] $_meritos
 * @property Competencia[] $_competencias
 * @property Puntualizacion[] $_puntualizaciones
 * @property Unidadnegocio[] $_unidadesnegocio
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
			array('nombre, codigo', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>90),
			array('codigo', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, codigo, estado', 'safe', 'on'=>'search'),
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
			'_puestospotencial1evaluacioncompetencia' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'puestopotencial1'),
			'_puestospotencial2evaluacioncompetencia' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'puestopotencial2'),
			'_puestospotencial3evaluacioncompetencia' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'puestopotencial3'),
			'_puestosevaluaciondesempeno' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'puesto'),
                        '_puestoevaluacioncompetencias' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'puesto'),
			'_puestospotencial1habilidadnoequivalente' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'puestopotencial1'),
			'_puestospotencial2habilidadnoequivalente' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'puestopotencial2'),
			'_puestospotencial3habilidadnoequivalente' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'puestopotencial3'),
			'_meritos' => array(self::HAS_MANY, 'Merito', 'puesto'),
                        '_historicopuestos' => array(self::HAS_MANY, 'Historicopuesto', 'puesto'),
			'_competencias' => array(self::MANY_MANY, 'Competencia', 'puestocompetencia(puesto, competencia)'),
			'_puntualizaciones' => array(self::MANY_MANY, 'Puntualizacion', 'puestopuntualizacion(puesto, puntualizacion)'),
			'_unidadesnegocio' => array(self::MANY_MANY, 'Unidadnegocio', 'unidadnegociopuesto(puesto, unidadnegocio)'),
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
			'codigo' => 'Codigo',
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
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('estado',$this->estado);
                //Muestra los puestos activos unicamente
                $criteria->addcolumncondition(array('estado'=>'1'));
                $criteria->order = 'nombre';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'Pagination'=>array('pageSize'=>'10'),
		));
	}
        
        public function addPuesto($idunidadnegocio)
        {
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
        
        /**
         * Returns an array with the values of the column needed.
         * @param array $unidades the array with the objects that have the column needed
         * @param string $columna  the name of the column that must be obtain
         */

        public function obtenerArrayColumna($unidades, $columna)
        {
            $idUnidades = array();
            foreach ($unidades as $un) {
                $idUnidades[] = $un->$columna;
            }
            return $idUnidades;
        }
        
        public function getmeritosactuales(){
            $meritos = Merito::model()->findAllByAttributes(array('puesto' => $this->id), 'estado=1');
            if(is_null($meritos))
                return false;
            else
                return  $meritos;
        }
        
        public function getcompetenciasactuales(){ 
            $idpuesto = $this->id;
            $connection=Yii::app()->db;
            $sql=  "SELECT pc.ponderacion, c.*                
                    FROM puestocompetencia pc
                    LEFT JOIN competencia c
                    ON (pc.competencia = c.id)                    
                    WHERE pc.puesto = :idpuesto
                    AND c.tipocompetencia = 2
                    AND c.estado = 1"; 
            $command=$connection->createCommand($sql);
            $command->bindParam(":idpuesto",$idpuesto);
            $competencias = $command->queryAll();
            if(is_null($competencias))
                return false;
            else
                return  $competencias;
        }
        
        public function getcompetenciascoreactuales(){ 
            $idpuesto = $this->id;
            $connection=Yii::app()->db;
            $sql=  "SELECT pc.ponderacion, c.*                
                    FROM puestocompetencia pc
                    LEFT JOIN competencia c
                    ON (pc.competencia = c.id)                    
                    WHERE pc.puesto = :idpuesto
                    AND c.tipocompetencia = 1
                    AND c.estado = 1"; 
            $command=$connection->createCommand($sql);
            $command->bindParam(":idpuesto",$idpuesto);
            $competenciascore = $command->queryAll();
            if(is_null($competenciascore))
                return false;
            else
                return  $competenciascore;
        }
        
        public function getname(){
            return $this->nombre;
        }
                
}

