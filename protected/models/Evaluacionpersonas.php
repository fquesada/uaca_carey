<?php

/**
 * This is the model class for table "evaluacionpersonas".
 *
 * The followings are the available columns in table 'evaluacionpersonas':
 * @property integer $id
 * @property string $fecha
 * @property integer $creador
 * @property integer $estado
 * @property integer $puesto
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property Evaluacioncompetencias[] $_evaluacionescompetencias
 * @property Colaborador $_creador
 * @property Puesto $_puesto
 * @property Habilidadespecial[] $_habilidadesespecial
 * @property Habilidadespecialevaluada[] $_habilidadesespecialevaluada
 * @property Vacante[] $_vacantes
 */
class Evaluacionpersonas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Evaluacionpersonas the static model class
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
		return 'evaluacionpersonas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, creador, puesto', 'required'),
			array('creador, estado, puesto', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>90),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, creador, estado, puesto, descripcionh', 'safe', 'on'=>'search'),
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
			'_evaluacionescompetencias' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'evaluacionpersonas'),
			'_creador' => array(self::BELONGS_TO, 'Colaborador', 'creador'),
			'_puesto' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
			'_habilidadesespecial' => array(self::HAS_MANY, 'Habilidadespecial', 'evaluacionpersonas'),
			'_habilidadesespecialevaluada' => array(self::HAS_MANY, 'Habilidadespecialevaluada', 'evaluacionpersonas'),
			'_vacantes' => array(self::HAS_MANY, 'Vacante', 'evaluacionpersonas'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'creador' => 'Creador',
			'estado' => 'Estado',
			'puesto' => 'Puesto',
			'descripcion' => 'Descripcion',
		);
	}

       public function search(){
            $connection=Yii::app()->db;
            $sql=   "SELECT evaluacionpersonas.id, evaluacionpersonas.descripcion, DATE_FORMAT(evaluacionpersonas.fecha, '%d-%m-%Y') AS fecha,
                    CONCAT(colaborador.nombre,' ',colaborador.apellido1,' ',colaborador.apellido2) AS creador,
                    puesto.nombre AS puesto, (CASE WHEN evaluacionpersonas.estado = 1 THEN 'En proceso' ELSE 'Finalizado' END) as estado                   
                    FROM evaluacionpersonas
                    INNER JOIN colaborador
                    ON (evaluacionpersonas.creador = colaborador.id)
                    INNER JOIN puesto
                    ON (evaluacionpersonas.puesto = puesto.id)"; 
            $command=$connection->createCommand($sql);
            $models = $command->queryAll();

            $dataProvider = new CArrayDataProvider($models,array(
            'keyField'=>'id',
            'id'=>'evaluacionpersonasgrid',
            'sort'=>array(
                'attributes'=>array(
                    'descripcion',
                    'fecha',
                    'creador',
                    'puesto',                       
                    'estado',
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>10,
                ),
            ));

            return $dataProvider;
        }
        
        public function obtenerevaluacionpersonasporevaluador($idcolaborador){
            $connection=Yii::app()->db;
            $sql=   "SELECT evaluacionpersonas.id, evaluacionpersonas.descripcion, DATE_FORMAT(evaluacionpersonas.fecha, '%d-%m-%Y') AS fecha,
                    puesto.nombre AS puesto                  
                    FROM evaluacionpersonas
                    INNER JOIN colaborador
                    ON (evaluacionpersonas.creador = colaborador.id and colaborador.id = :idcolaborador)
                    INNER JOIN puesto
                    ON (evaluacionpersonas.puesto = puesto.id)"; 
            $command=$connection->createCommand($sql);
            $command->bindParam(":idcolaborador", $idcolaborador, PDO::PARAM_INT);
            $models = $command->queryAll();

            $dataProvider = new CArrayDataProvider($models,array(
            'keyField'=>'id',
            'id'=>'evaluacionpersonasgrid',
            'sort'=>array(
                'attributes'=>array(
                    'descripcion',
                    'fecha',                    
                    'puesto'                                          
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>10,
                ),
            ));

            return $dataProvider;
        }
}