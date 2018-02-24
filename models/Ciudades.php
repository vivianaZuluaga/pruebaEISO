<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ciudades".
 *
 * @property integer $id
 * @property integer $codigo_departamento
 * @property string $nombre_departamento
 * @property integer $codigo_municipio
 * @property string $nombre_municipio
 *
 * @property VentasUsuarios[] $ventasUsuarios
 */
class Ciudades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ciudades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo_departamento', 'nombre_departamento', 'codigo_municipio', 'nombre_municipio'], 'required'],
            [['codigo_departamento', 'codigo_municipio'], 'integer'],
            [['nombre_departamento', 'nombre_municipio'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo_departamento' => 'Codigo Departamento',
            'nombre_departamento' => 'Nombre Departamento',
            'codigo_municipio' => 'Codigo Municipio',
            'nombre_municipio' => 'Nombre Municipio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVentasUsuarios()
    {
        return $this->hasMany(VentasUsuarios::className(), ['ciudad' => 'id']);
    }
}
