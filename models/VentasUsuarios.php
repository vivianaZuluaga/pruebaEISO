<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ventas_usuarios".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $producto_id
 * @property integer $cantidad
 * @property string $fecha_venta
 * @property double $valor
 * @property integer $ciudad
 *
 * @property Ciudades $ciudad0
 * @property Productos $producto
 * @property Usuarios $usuario
 */
class VentasUsuarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ventas_usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'cantidad', 'valor', 'ciudad', 'fecha_venta', 'producto_id'], 'required'],
            [['usuario_id', 'producto_id', 'ciudad'], 'integer'],
            [['fecha_venta'], 'safe'],
            [['valor'], 'number'],
            [['cantidad'], 'integer', 'min' => 1],
            [['ciudad'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudades::className(), 'targetAttribute' => ['ciudad' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'cedula']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario',
            'producto_id' => 'Producto',
            'cantidad' => 'Cantidad',
            'fecha_venta' => 'Fecha Venta',
            'valor' => 'Valor',
            'ciudad' => 'Ciudad',
        ];
    }


    /**
     * 
    */
    public function behaviors()
    {
        return [
                "dueDateAfterFind" => [
                                        "class" => TimestampBehavior::className(),
                                        "attributes" => [ActiveRecord::EVENT_AFTER_FIND => "fecha_venta"],
                                        "value" => function() 
                                        { 
                                            return Yii::$app->formatter->asDate($this->fecha_venta, "Y-MM-dd"); 
                                        }       
                                      ]                               
                ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCiudad0()
    {
        return $this->hasOne(Ciudades::className(), ['id' => 'ciudad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['cedula' => 'usuario_id']);
    }
}
