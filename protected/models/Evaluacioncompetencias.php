<?php

/**
 * This is the model class for table "evaluacioncompetencias".
 *
 * The followings are the available columns in table 'evaluacioncompetencias':
 * @property integer $id
 * @property integer $procesoevaluacion
 * @property string $fechaevaluacion
 * @property integer $puestopotencial1
 * @property integer $puestopotencial2
 * @property integer $puestopotencial3
 * @property double $promedioponderado
 * @property integer $tipo
 * @property string $comentario
 * @property integer $links
 * @property integer $puesto
 * @property integer $colaborador
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Puesto $_puestopotencial1
 * @property Puesto $_puestopotencial2
 * @property Puesto $_puestopotencial3
 * @property Procesoevaluacion $_procesoevaluacion
 * @property Links $_links
 * @property Puesto $_puesto
 * @property Colaborador $_colaborador
 * @property Habilidadespecialevaluada[] $_habilidadesespecialevaluada
 * @property Habilidadevaluacioncandidato[] $_habilidadesevaluacioncandidato
 * @property Habilidadnoequivalente[] $_habilidadesnoequivalente
 * @property Meritoevaluacioncandidato[] $_meritosevaluacioncandidato
 * @property Origenevaluacion[] $_origenesevaluacion
 */
class Evaluacioncompetencias extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Evaluacioncompetencias the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'evaluacioncompetencias';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('procesoevaluacion, puesto, colaborador', 'required'),
            array('procesoevaluacion, puestopotencial1, puestopotencial2, puestopotencial3, tipo, links, puesto, colaborador, estado', 'numerical', 'integerOnly' => true),
            array('promedioponderado', 'numerical'),
            array('comentario', 'length', 'max' => 800),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, procesoevaluacion, fechaevaluacion, puestopotencial1, puestopotencial2, puestopotencial3, promedioponderado, tipo, links, puesto, colaborador, estado', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            '_puestopotencial1' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial1'),
            '_puestopotencial2' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial2'),
            '_puestopotencial3' => array(self::BELONGS_TO, 'Puesto', 'puestopotencial3'),
            '_procesoevaluacion' => array(self::BELONGS_TO, 'Procesoevaluacion', 'procesoevaluacion'),
            '_links' => array(self::BELONGS_TO, 'Links', 'links'),
            '_puesto' => array(self::BELONGS_TO, 'Puesto', 'puesto'),
            '_colaborador' => array(self::BELONGS_TO, 'Colaborador', 'colaborador'),
            '_habilidadesespecialevaluada' => array(self::HAS_MANY, 'Habilidadespecialevaluada', 'evaluacioncompetencias'),
            '_habilidadesevaluacioncandidato' => array(self::HAS_MANY, 'Habilidadevaluacioncandidato', 'evaluacioncandidato'),
            '_habilidadesnoequivalente' => array(self::HAS_MANY, 'Habilidadnoequivalente', 'evaluacioncandidato'),
            '_meritosevaluacioncandidato' => array(self::HAS_MANY, 'Meritoevaluacioncandidato', 'evaluacioncandidato'),
            '_origenesevaluacion' => array(self::MANY_MANY, 'Origenevaluacion', 'evaluacioncompetenciasorigen(evaluacioncompetencias, origenevaluacion)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'procesoevaluacion' => 'Proceso Evaluacion',
            'fechaevaluacion' => 'Fechaevaluacion',
            'puestopotencial1' => 'Puestopotencial1',
            'puestopotencial2' => 'Puestopotencial2',
            'puestopotencial3' => 'Puestopotencial3',
            'promedioponderado' => 'Promedioponderado',
            'tipo' => 'Tipo',
            'comentario' => 'Comentario',
            'links' => 'Links',
            'puesto' => 'Puesto',
            'colaborador' => 'Colaborador',
            'estado' => 'Estado',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('procesoevaluacion', $this->procesoevaluacion);
        $criteria->compare('fechaevaluacion', $this->fechaevaluacion, true);
        $criteria->compare('puestopotencial1', $this->puestopotencial1);
        $criteria->compare('puestopotencial2', $this->puestopotencial2);
        $criteria->compare('puestopotencial3', $this->puestopotencial3);
        $criteria->compare('promedioponderado', $this->promedioponderado);
        $criteria->compare('tipo', $this->tipo);
        $criteria->compare('comentario', $this->comentario, true);
        $criteria->compare('links', $this->links);
        $criteria->compare('puesto', $this->puesto);
        $criteria->compare('colaborador', $this->colaborador);
        $criteria->compare('estado', $this->estado);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function getTipoEvaluado() {
        $estado = 'Interno';
        if ($this->tipo == 0)
            $estado = 'Externo';

        return $estado;
    }

    public function getNombreEvaluado() {
        if ($this->tipo == 1)
            return Colaborador::model()->findByPk($this->evaluado)->nombrecompleto;
        else
            return Postulante::model()->findByPk($this->evaluado)->nombrecompleto;
    }

    public function getEstadoEvaluacionDescripcion() {
        if ($this->estado == 1)
            return 'Pendiente';
        else if ($this->estado == 2)
            return 'Evaluado';
    }
    
    public function getEstadoEvaluacionIndicador() {
        if ($this->estado == 1)
            return false;
        else if ($this->estado == 2)
            return true;
    }
    
    public function getfechaevaluacionecformato() {
        if (is_null($this->fechaevaluacion))
            return "-- / -- / ----";
        else {
            $fechasinformato = strtotime($this->fechaevaluacion);
            $fechaconformato = date('d-m-Y', $fechasinformato);
            return $fechaconformato;
        }
    }

//        public function obtenerGraficoSpiderCalificado($idevaluacioncompetencias,$idevaluacionpersonas){
//            
//            $connection=Yii::app()->db;
//            $sql = "SELECT tm.nombre as 'eje',mec.calificacion as 'calificacion'
//                    FROM meritoevaluacioncandidato mec
//                    INNER JOIN merito m ON mec.merito = m.id
//                    INNER JOIN tipomerito tm ON tm.id =  m.tipomerito
//                    WHERE mec.evaluacioncandidato = :idevaluacioncompetencias
//                    UNION
//                    SELECT c.competencia as 'eje',hec.calificacion as 'calificacion'
//                    FROM habilidadevaluacioncandidato hec
//                    INNER JOIN competencia c ON hec.competencia = c.id
//                    WHERE hec.evaluacioncandidato = :idevaluacioncompetencias
//                    UNION
//                    SELECT h.nombre as 'eje',he.calificacion as 'calificacion'
//                    FROM Habilidadespecialevaluada he
//                    INNER JOIN Habilidadespecial h ON he.evaluacionpersonas = h.evaluacionpersonas
//                    AND he.habilidadespecial = h.id
//                    WHERE he.evaluacionpersonas = :idevaluacionpersonas AND he.evaluacioncompetencias = :idevaluacioncompetencias";
//            $command = $connection->createCommand($sql);
//            $command->bindParam(":idevaluacionpersonas", $idevaluacionpersonas, PDO::PARAM_INT);
//            $command->bindParam(":idevaluacioncompetencias", $idevaluacioncompetencias, PDO::PARAM_INT);            
//            $dataspider = $command->queryAll();
//            
//            if(empty($dataspider))
//                return false;
//            else 
//                return $dataspider;
//        }

    public function obtenerdatosgraficospider($idevaluacioncompetencias, $idevaluacionpersonas) {

        $connection = Yii::app()->db;
        $sql = "SELECT tm.nombre as 'eje',mec.calificacion as 'calificacion', mec.ponderacion as 'ponderacion'
                    FROM meritoevaluacioncandidato mec
                    INNER JOIN merito m ON mec.merito = m.id
                    INNER JOIN tipomerito tm ON tm.id =  m.tipomerito
                    WHERE mec.evaluacioncandidato = :idevaluacioncompetencias
                    UNION
                    SELECT c.competencia as 'eje',hec.calificacion as 'calificacion', hec.ponderacion as 'ponderacion'
                    FROM habilidadevaluacioncandidato hec
                    INNER JOIN competencia c ON hec.competencia = c.id
                    WHERE hec.evaluacioncandidato = :idevaluacioncompetencias
                    UNION
                    SELECT h.nombre as 'eje',he.calificacion as 'calificacion', h.ponderacion as 'ponderacion'
                    FROM Habilidadespecialevaluada he
                    INNER JOIN Habilidadespecial h ON he.evaluacionpersonas = h.evaluacionpersonas
                    AND he.habilidadespecial = h.id
                    WHERE he.evaluacionpersonas = :idevaluacionpersonas AND he.evaluacioncompetencias = :idevaluacioncompetencias";
        $command = $connection->createCommand($sql);
        $command->bindParam(":idevaluacionpersonas", $idevaluacionpersonas, PDO::PARAM_INT);
        $command->bindParam(":idevaluacioncompetencias", $idevaluacioncompetencias, PDO::PARAM_INT);
        $dataspider = $command->queryAll();

        if (empty($dataspider))
            return false;
        else
            return $dataspider;
    }

    public function obtenerGraficoSpiderRelativo($idevaluacioncompetencias, $idevaluacionpersonas) {

        $connection = Yii::app()->db;
        if ($this->tipo == 1) {
            $sql = "SELECT tm.nombre as 'eje', m.ponderacion as 'calificacion'
                    FROM evaluacioncompetencias ec                     
                    INNER JOIN colaborador co ON ec.evaluado = co.id
                    INNER JOIN unidadnegociopuesto up ON co.puesto = up.puesto
                    INNER JOIN puesto p ON up.puesto = p.id
                    INNER JOIN merito m ON m.puesto = p.id
                    INNER JOIN tipomerito tm ON tm.id =  m.tipomerito                    
                    AND ec.id = :idevaluacioncompetencias
                    UNION
                    SELECT c.competencia as 'eje', pc.ponderacion as 'calificacion'
                    FROM habilidadevaluacioncandidato hec
                    INNER JOIN evaluacioncompetencias ec ON hec.evaluacioncandidato = ec.id
                    INNER JOIN competencia c ON hec.competencia = c.id
                    INNER JOIN puestocompetencia pc ON c.id = pc.competencia
                    INNER JOIN colaborador co ON ec.evaluado = co.id
                    INNER JOIN unidadnegociopuesto up ON co.puesto = up.puesto
                    INNER JOIN puesto p ON up.puesto = p.id
                    WHERE pc.puesto = p.id
                    AND hec.evaluacioncandidato = :idevaluacioncompetencias
                    UNION
                    SELECT he.nombre as 'eje',he.ponderacion as 'calificacion'
                    FROM Habilidadespecial he
                    INNER JOIN evaluacionpersonas e ON he.evaluacionpersonas = e.id
                    WHERE he.evaluacionpersonas = :idevaluacionpersonas";
        }
        $command = $connection->createCommand($sql);
        $command->bindParam(":idevaluacionpersonas", $idevaluacionpersonas, PDO::PARAM_INT);
        $command->bindParam(":idevaluacioncompetencias", $idevaluacioncompetencias, PDO::PARAM_INT);
        $dataspider = $command->queryAll();

        if (empty($dataspider))
            return false;
        else
            return $dataspider;
    }
    
    public function promedioponderado($meritos, $habilidades){        
        
        $dividendo = 0;
        $divisor = 0;
        
        foreach ($meritos as $merito) {
            $dividendo = $dividendo + CommonFunctions::stringtonumber($merito["calificacionmerito"]) *  CommonFunctions::stringtonumber($merito["ponderacion"]);
            $divisor = $divisor + CommonFunctions::stringtonumber($merito["ponderacion"]);           
        }
        
        foreach ($habilidades as $habilidad) {
            $dividendo = $dividendo + CommonFunctions::stringtonumber($habilidad["calificacionhabilidad"]) *  CommonFunctions::stringtonumber($habilidad["ponderacion"]);
            $divisor = $divisor + CommonFunctions::stringtonumber($habilidad["ponderacion"]);           
        }
        
        if($divisor==0)
            $promedioponderado = 0;
        else        
            $promedioponderado = $dividendo / $divisor;
        
        return $promedioponderado;        
    }    
     
    function validarmeritos($meritos){
        //FALTA
    }
    
    function validarhabilidades($habilidades){
        //FALTA
    }
    
    function validarpuntaje($valor, $puntaje){
        //FALTA
    }


}
