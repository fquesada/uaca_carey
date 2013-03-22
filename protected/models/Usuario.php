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
 *
 * The followings are the available model relations:
 * @property Colaborador[] $_colaboradores
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
                                array('login, empresa', 'required', 'on'=>'update'),
                                array('password_actual, password_nueva, confirmarPassword', 'required', 'on'=>'CambiarPass'),
                                array('estado, empresa', 'numerical', 'integerOnly'=>true),
                                array('login', 'length', 'max'=>45),
                                array('password', 'length', 'max'=>100),
                                // The following rule is used by search().
                                // Please remove those attributes that should not be searched.
                                array('id, login, password, fechacreacion, estado, empresa', 'safe', 'on'=>'search'),
                                array('password', 'compare', 'compareAttribute' => 'confirmarPassword', 'on'=>'create', 'message'=>'Las contraseñas no son iguales, introduzcalas de nuevo'),
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
			'_colaboradores' => array(self::MANY_MANY, 'Colaborador', 'colaboradorusuario(usuario, colaborador)'),
			'_empresa' => array(self::BELONGS_TO, 'Empresa', 'empresa'),
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
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fechacreacion',$this->fechacreacion,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('empresa',$this->empresa);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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