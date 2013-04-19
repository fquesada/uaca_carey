<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $fechacreacion
 * @property integer $estado
 * @property integer $empresa
 * @property integer $estadopassword
 *
 * The followings are the available model relations:
 * @property Colaborador[] $_colaboradores
 * @property Historialcontrasenas[] $_historialcontrasenas
 * @property Historialcontrasenas[] $_historialcontrasenaseditor
 * @property Empresa $_empresa
 */
class Usuario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
    
        private $salt = '$2y$06$Un2C0ntRaZenap2r2L0Gy';    //El salt para cryp  
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}
        
        public $confirmarPassword;
        public $password_actual;
        public $password_nueva;
        public $colaborador;
        public $confirmacion;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('login, password, confirmarPassword', 'required','on'=>'create'),
                                array('login', 'unique'),
                                array('login, empresa', 'required', 'on'=>'update'),
                                array('password_actual, password_nueva, confirmarPassword', 'required', 'on'=>'CambiarPass'),
                                array('estado, empresa, estadopassword', 'numerical', 'integerOnly'=>true),
                                array('login', 'length', 'max'=>45),
                                array('password', 'length', 'max'=>100),
                                // The following rule is used by search().
                                // Please remove those attributes that should not be searched.
                                array('id, login, password, fechacreacion, estado, empresa', 'safe', 'on'=>'search'),
                                array('confirmarPassword', 'compare', 'compareAttribute' => 'password', 'on'=>'create', 'message'=>'Las contraseñas no son iguales, introduzcalas de nuevo'),
                                array('password_nueva', 'compare', 'compareAttribute' => 'confirmarPassword', 'on'=>'CambiarPass', 'message'=>'Las contraseñas no son iguales, introduzcalas de nuevo'),
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
                        '_historialcontrasenas' => array(self::HAS_MANY, 'Historialcontrasenas', 'usuario'),
			'_historialcontrasenaseditor' => array(self::HAS_MANY, 'Historialcontrasenas', 'usuarioeditor'),
			'_colaboradores' => array(self::MANY_MANY, 'Colaborador', 'colaboradorusuario(usuario, colaborador)'),
			'_empresa' => array(self::BELONGS_TO, 'Empresa', 'empresa'),
                        '_usuario' => array(self::HAS_ONE,'colaboradorusuario','usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'password' => 'Password',
			'fechacreacion' => 'Fechacreacion',
			'estado' => 'Estado',
			'empresa' => 'Empresa',
                        'estadopassword' => 'Estadopassword',
                        
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
            $connection=Yii::app()->db;
            $sql= "SELECT colaboradorusuario.usuario,
                    CONCAT(colaborador.nombre,' ',colaborador.apellido1,' ',colaborador.apellido2) AS colaborador                
                    FROM colaboradorusuario
                    INNER JOIN colaborador
                    ON (colaboradorusuario.colaborador = colaborador.id)"; 
            
            $command=$connection->createCommand($sql);
            $models = $command->queryAll();

            $dataProvider = new CArrayDataProvider($models,array(
            'keyField'=>'usuario',
            'id'=>'usuariosgrid',
            'sort'=>array(
                'attributes'=>array(
                    'colaborador',
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>10,
                ),
            ));

            return $dataProvider;
	}
        
        public function getsalt(){            
            return $this->salt;
        }
        
        /*          
	 * @return object type Colaborador, si no tiene Colaborador retorna false
	 */
        public function getcolaborador(){
            $colaboradores = $this->_colaboradores;
            reset($colaboradores);
            return current($colaboradores);        
        }
        
        /*          
	 * @return true tiene colaboradores
	 */
        public function hascolaborador(){
            if(count($this->_colaboradores) > 0)
                return true;
            else
                return false;
        }
}
