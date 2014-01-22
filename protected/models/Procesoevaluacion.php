<?php

/**
 * This is the model class for table "procesoevaluacion".
 *
 * The followings are the available columns in table 'procesoevaluacion':
 * @property integer $id
 * @property string $fecha
 * @property integer $evaluador
 * @property integer $estado
 * @property string $descripcion
 * @property integer $tipo
 * @property integer $periodo
 *
 * The followings are the available model relations:
 * @property Evaluacioncompetencias[] $_evaluacionescompetencias
 * @property Evaluaciondesempeno[] $_evaluaciondesempeno
 * @property Colaborador $_evaluador
 * @property Periodo $_periodo
 * @property Habilidadespecial[] $_habilidadesespecial
 * @property Habilidadespecialevaluada[] $_habilidadesespecialevaluada
 * @property Vacante[] $_vacantes
 */
class Procesoevaluacion  extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Procesoevaluacion the static model class
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
		return 'procesoevaluacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, evaluador, tipo', 'required'),
			array('evaluador, estado, tipo, periodo', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>90),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, evaluador, estado, descripcion, tipo, periodo', 'safe', 'on'=>'search'),
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
			'_evaluacionescompetencias' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'procesoevaluacion', 'condition'=>'estado <> 0',),
                        '_evaluaciondesempenos' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'procesoevaluacion'),					
			'_habilidadesespecial' => array(self::HAS_MANY, 'Habilidadespecial', 'procesoevaluacion'),
			'_habilidadesespecialevaluada' => array(self::HAS_MANY, 'Habilidadespecialevaluada', 'procesoevaluacion'),
			'_vacantes' => array(self::HAS_MANY, 'Vacante', 'procesoevaluacion'),
                        '_evaluador' => array(self::BELONGS_TO, 'Colaborador', 'evaluador'),
                        '_periodo' => array(self::BELONGS_TO, 'Periodo', 'periodo'),	
                        	
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha creacion',
			'evaluador' => 'Evaluador',
			'estado' => 'Estado',
			'descripcion' => 'Descripcion',
                        'tipo' => 'Tipo',
                        'periodo' => 'Periodo',
		);
	}

       public function obtenerevaluacioncompetencias(){//CLEAN CODE
            $connection=Yii::app()->db;
            $sql=  "SELECT pe.id, pe.descripcion, p.nombre as periodo, DATE_FORMAT(pe.fecha, '%d/%m/%Y') AS fecha, CONCAT(c.nombre,' ',c.apellido1,' ',c.apellido2) AS evaluador,(CASE WHEN pe.estado = 1 THEN 'En proceso' ELSE 'Finalizado' END) as estado                   
                    FROM procesoevaluacion pe
                    INNER JOIN periodo p
                    ON (pe.periodo = p.id)
                    INNER JOIN colaborador c
                    ON (pe.evaluador = c.id)
                    WHERE pe.tipo = 1
                    AND pe.estado <> 0;"; 
            $command=$connection->createCommand($sql);
            $ec = $command->queryAll();
            $dataProvider = new CArrayDataProvider($ec,array(
            'keyField'=>'id',
            'id'=>'procesoevaluaciongrid',
            'sort'=>array(
                'attributes'=>array(
                    'descripcion',
                    'periodo',
                    'fecha',                    
                    'evaluador',                       
                    'estado',
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>15,
                ),
            ));
            return $dataProvider;
        }
        
       public function getEstadoProceso() {
        if ($this->estado == 1)
            return 'En proceso';
        else if ($this->estado == 2)
            return 'Finalizado';
      }
      
       public function getFechaProcesoFormato(){
          $fechasinformato = strtotime($this->fecha);          
          $fechaconformato = date('d/m/Y', $fechasinformato);          
          return $fechaconformato;
       }
     
       public function getTipoEvaluado() {
        $estado = 'Interno';
        if ($this->tipo == 0)
            $estado = 'Externo';

        return $estado;
    }

           
}
