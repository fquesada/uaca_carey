<?php

/**
 * This is the model class for table "calificacioncompetencia".
 *
 * The followings are the available columns in table 'calificacioncompetencia':
 * @property integer $id
 * @property integer $evaluacion
 * @property integer $competencia
 * @property integer $tipocompetencia
 * @property integer $ponderacion
 * @property integer $puntaje
 *
 * The followings are the available model relations:
 * @property Competencia $_competencia
 * @property Evaluaciondesempeno $_evaluacion
 */
class Calificacioncompetencia extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Calificacioncompetencia the static model class
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
        return 'calificacioncompetencia';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('evaluacion, competencia, tipocompetencia, ponderacion, puntaje', 'required'),
            array('evaluacion, competencia, tipocompetencia, ponderacion, puntaje', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, evaluacion, competencia, tipocompetencia, ponderacion, puntaje', 'safe', 'on'=>'search'),
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
            '_competencia' => array(self::BELONGS_TO, 'Competencia', 'competencia'),
            '_evaluacion' => array(self::BELONGS_TO, 'Evaluaciondesempeno', 'evaluacion'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'evaluacion' => 'Evaluacion',
            'competencia' => 'Competencia',
            'tipocompetencia' => 'Tipo Competencia',
            'ponderacion' => 'Ponderacion',
            'puntaje' => 'Puntaje',
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
        $criteria->compare('evaluacion',$this->evaluacion);
        $criteria->compare('competencia',$this->competencia);
        $criteria->compare('tipocompetencia',$this->tipocompetencia);
        $criteria->compare('ponderacion',$this->ponderacion);
        $criteria->compare('puntaje',$this->puntaje);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}