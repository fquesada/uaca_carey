<?php

/**
 * This is the model class for table "historicopuesto".
 *
 * The followings are the available columns in table 'historicopuesto':
 * @property integer $id
 * @property string $fechadesignacion
 * @property integer $colaborador
 * @property integer $puestoactual
 * @property integer $unidadnegocio
 * @property integer $puesto
 *
 * The followings are the available model relations:
 * @property Unidadnegociopuesto $_unidadnegocio
 * @property Unidadnegociopuesto $_puesto
 * @property Colaborador $_colaborador
 */
class Historicopuesto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Historicopuesto the static model class
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
		return 'historicopuesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fechadesignacion, colaborador, puestoactual, unidadnegocio, puesto', 'required'),
			array('colaborador, puestoactual, unidadnegocio', 'numerical', 'integerOnly'=>true),
                        array('puesto', 'numerical', 'message'=>'Puesto no puede ser nulo.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fechadesignacion, colaborador, puestoactual, unidadnegocio, puesto', 'safe', 'on'=>'search'),
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
			'_unidadnegocio' => array(self::BELONGS_TO, 'Unidadnegociopuesto', 'unidadnegocio'),
			'_puesto' => array(self::BELONGS_TO, 'Unidadnegociopuesto', 'puesto'),
			'_colaborador' => array(self::BELONGS_TO, 'Colaborador', 'colaborador'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fechadesignacion' => 'Inicio de labores',
			'colaborador' => 'Colaborador',
                        'puestoactual' => 'Puestoactual',
			'unidadnegocio' => 'Unidad de Negocio',
			'puesto' => 'Puesto',
                        'nombreunidadnegocio' => 'Unidad de Negocio',
                        'nombrepuesto' => 'Puesto',
		);
	}
        
        public function getNombreunidadnegocio (){
            $unidadnegocio = Unidadnegocio::model()->findByPk($this->unidadnegocio);
            $resultado = $unidadnegocio->nombre;
            
            return $resultado;          
        }
        
        public function getNombrepuesto (){
            $puesto = Puesto::model()->findByPk($this->puesto);
            $resultado = $puesto->nombre;

            return $resultado;
        }
        
        //Todavia no se ha usado en nada
        public function getNombrecolaborador (){
            $colaborador = Colaborador::model()->findByAttributes(array('id'=>$this->colaborador));
            foreach ($colaborador as $persona){
                $resultado = $persona->nombre;
            }
            return $resultado;
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
		$criteria->compare('fechadesignacion',$this->fechadesignacion,true);
		$criteria->compare('colaborador',$this->colaborador);
                $criteria->compare('puestoactual',$this->puestoactual);
		$criteria->compare('unidadnegocio',$this->unidadnegocio);
		$criteria->compare('puesto',$this->puesto);
               

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}