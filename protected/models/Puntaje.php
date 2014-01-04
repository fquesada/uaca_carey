<?php

/**
 * This is the model class for table "puntaje".
 *
 * The followings are the available columns in table 'puntaje':
 * @property integer $id
 * @property integer $valor
 * @property integer $estado
 * @property string $descripcion
 */

class Puntaje extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Puntaje the static model class
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
		return 'puntaje';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('valor, estado, descripcion', 'required'),
			array('valor, estado', 'numerical', 'integerOnly'=>true),
                        array('descripcion', 'length', 'max'=>400),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, valor, estado, descripcion', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'valor' => 'Valor',			
			'estado' => 'Estado',
                        'descripcion'=> 'Descripción'
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
		$criteria->compare('valor',$this->valor);		
		$criteria->compare('estado',$this->estado);
                $criteria->compare('descripcion',$this->descripcion, true);
                $criteria->addColumnCondition(array('estado'=>'1'));                
                $criteria->order = 'valor';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function obtenerpuntajesactivos(){
            return $this->findAll('estado=1');
        }
}

