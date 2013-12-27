<?php

/**
 * This is the model class for table "competenciacore".
 *
 * The followings are the available columns in table 'competenciacore':
 * @property integer $id
 * @property string $competencia
 * @property string $descripcion
 * @property string $pregunta
 * @property integer $estado
 * @property integer $ponderacion
 */
class Competenciacore extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Competenciacore the static model class
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
        return 'competenciacore';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('competencia, descripcion, pregunta, ponderacion', 'required'),
            array('estado, ponderacion', 'numerical', 'integerOnly'=>true),
            array('competencia', 'length', 'max'=>400),
            array('descripcion', 'length', 'max'=>800),
            array('pregunta', 'length', 'max'=>1500),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, competencia, descripcion, pregunta, estado, ponderacion', 'safe', 'on'=>'search'),
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
            'competencia' => 'Competencia',
            'descripcion' => 'Descripcion',
            'pregunta' => 'Pregunta',
            'estado' => 'Estado',
            'ponderacion' => 'Ponderacion',
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
        $criteria->compare('competencia',$this->competencia,true);
        $criteria->compare('descripcion',$this->descripcion,true);
        $criteria->compare('pregunta',$this->pregunta,true);
        $criteria->compare('estado',$this->estado);
        $criteria->compare('ponderacion',$this->ponderacion);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}