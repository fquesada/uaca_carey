<?php

/**
 * This is the model class for table "merito".
 *
 * The followings are the available columns in table 'merito':
 * @property integer $id
 * @property integer $tipomerito
 * @property integer $ponderacion
 * @property integer $puesto
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property Puesto $_puesto
 * @property Tipomerito $_tipomerito
 * @property Meritoevaluacioncandidato[] $_meritosevaluacioncandidato
 */
class Merito extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Merito the static model class
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
		return 'merito';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipomerito, ponderacion, puesto', 'required'),
			array('tipomerito, ponderacion, puesto', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>800),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tipomerito, ponderacion, puesto, descripcion', 'safe', 'on'=>'search'),
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
			'_puesto' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
			'_tipomerito' => array(self::BELONGS_TO, 'Tipomerito', 'tipomerito'),
			'_meritosevaluacioncandidato' => array(self::HAS_MANY, 'Meritoevaluacioncandidato', 'merito'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipomerito' => 'Tipo merito',
			'ponderacion' => 'Ponderación',
			'puesto' => 'Puesto',
			'descripcion' => 'Descripción',
                        'NombreTipoMerito' => 'Tipo merito',
                        'NombrePuesto' => 'Puesto',
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
		$criteria->compare('tipomerito',$this->tipomerito);
		$criteria->compare('ponderacion',$this->ponderacion);
		$criteria->compare('puesto',$this->puesto);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNombreTipoMerito(){
            
            $tipomerito = Tipomerito::model()->findAllByAttributes(array('id'=> $this->tipomerito));
            foreach ($tipomerito as $tmerito){
                $resultado = $tmerito->nombre;
            }
            
            if (isset($resultado)){
            return $resultado;
            }
        }
        
         public function getNombrePuesto(){
            
            $puestos = Puesto::model()->findAllByAttributes(array('id'=>  $this->puesto));
            foreach ($puestos as $puesto){
                $resultado = $puesto->nombre;
            }
            
            if (isset($resultado)){
            return $resultado;
            }
        }
}