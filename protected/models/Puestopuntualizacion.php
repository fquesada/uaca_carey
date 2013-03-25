<?php

/**
 * This is the model class for table "puestopuntualizacion".
 *
 * The followings are the available columns in table 'puestopuntualizacion':
 * @property integer $puntualizacion
 * @property integer $puesto
 */
class Puestopuntualizacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Puestopuntualizacion the static model class
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
		return 'puestopuntualizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('puntualizacion, puesto', 'required'),
			array('puntualizacion, puesto', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('puntualizacion, puesto', 'safe', 'on'=>'search'),
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
			'puntualizacion' => 'Puntualización',
			'puesto' => 'Puesto',
                        'NombrePunt'=>'Puntualización',
                        'IndicadorPunt'=>'Indicador'
		);
	}

        public function getNombrePunt(){

            $puntualizacion = puntualizacion::model()->findAllByAttributes(array('id'=>$this->puntualizacion));
            foreach ($puntualizacion as $pun){
                $resultado = $pun->puntualizacion;
            }
            return $resultado;
            
        }
        
        public function getIndicadorPunt(){

            $puntualizacion = puntualizacion::model()->findAllByAttributes(array('id'=>$this->puntualizacion));
            foreach ($puntualizacion as $pun){
                $resultado = $pun->indicadorpuntualizacion;
            }
            return $resultado;

        }

    /**
* Retrieves a list of models based on the current search/filter conditions.
* @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
*/
    public function search($idpuesto)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('puntualizacion',$this->puntualizacion);
            $criteria->compare('puesto',$this->puesto);
            
            $criteria->addColumnCondition(array('puesto'=>$idpuesto));
            
            $puntualizaciones = Puntualizacion::model()->findAllByAttributes(array('estado'=>'1'));
            $puntualizacionesvalidas = $this->obtenerArrayColumna($puntualizaciones, 'id');
            
            $criteria->addInCondition('puntualizacion', $puntualizacionesvalidas);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
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
}