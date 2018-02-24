<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "usuarios".
 *
 * @property integer $cedula
 * @property string $nombre
 * @property string $usuario
 * @property string $passwd
 * @property string $email
 * @property integer $estado
 * @property string $fecha_registro
 * @property string $fecha_actualizacion
 * @property integer $edad
 * @property integer $rol
 *
 * @property Roles $rol0
 * @property VentasUsuarios[] $ventasUsuarios
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cedula', 'nombre', 'usuario', 'passwd', 'email', 'edad', 'rol'], 'required'],
            [['estado', 'rol'], 'integer'],
            [['cedula'], 'string', 'max' => 10, 'min'=> 5],
            [['cedula'], 'integer'],
            [['edad'], 'integer', 'max' => 103, 'min'=> 18],
            [['fecha_registro', 'fecha_actualizacion'], 'safe'],
            [['nombre'], 'string', 'max' => 100, 'min'=> 8],
            [['usuario'], 'string', 'max' => 20, 'min'=> 4],
            [['passwd'], 'string', 'max' => 8, 'min'=> 6],
            [['email'], 'email'],
            [['usuario'], 'unique'],
            [['email'], 'unique'],
            [['rol'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['rol' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cedula' => 'Cedula',
            'nombre' => 'Nombre',
            'usuario' => 'Usuario',
            'passwd' => 'Passwd',
            'email' => 'Email',
            'estado' => 'Estado',
            'fecha_registro' => 'Fecha Registro',
            'fecha_actualizacion' => 'Fecha Actualizacion',
            'edad' => 'Edad',
            'rol' => 'Rol',
        ];
    }

    /**
     * 
    */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'fecha_registro',
                'updatedAtAttribute' => 'fecha_actualizacion',
                'value' => new Expression('NOW()'),
            ],
            //[
            //'class' => BlameableBehavior::className(),
            //'createdByAttribute' => 'rol',
            //'updatedByAttribute' => false,
            //'value' => '1',
            //],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol0()
    {
        return $this->hasOne(Roles::className(), ['id' => 'rol']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVentasUsuarios()
    {
        return $this->hasMany(VentasUsuarios::className(), ['usuario_id' => 'cedula']);
    }
}
