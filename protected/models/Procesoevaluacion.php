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
			'_evaluacionescompetencias' => array(self::HAS_MANY, 'Evaluacioncompetencias', 'procesoevaluacion'),
                        'evaluaciondesempenos' => array(self::HAS_MANY, 'Evaluaciondesempeno', 'procesoevaluacion'),					
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
			'fecha' => 'Fecha',
			'evaluador' => 'Evaluador',
			'estado' => 'Estado',
			'descripcion' => 'Descripcion',
                        'tipo' => 'Tipo',
                        'periodo' => 'Periodo',
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
}