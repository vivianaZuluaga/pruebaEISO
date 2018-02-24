<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property double $valor
 * @property double $precio_venta
 * @property integer $cantidad
 * @property integer $tipo_producto
 *
 * @property TiposProductos $tipoProducto
 * @property VentasUsuarios[] $ventasUsuarios
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'valor', 'precio_venta', 'cantidad', 'tipo_producto'], 'required'],
            [['valor', 'precio_venta'], 'number', 'min' => 1],
            [['tipo_producto'], 'integer'],
            [['cantidad'], 'integer', 'min' => 1],
            [['nombre'], 'string', 'max' => 80],
            [['descripcion'], 'string', 'max' => 250],
            [['tipo_producto'], 'exist', 'skipOnError' => true, 'targetClass' => TiposProductos::className(), 'targetAttribute' => ['tipo_producto' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'valor' => 'Valor',
            'precio_venta' => 'Precio Venta',
            'cantidad' => 'Cantidad',
            'tipo_producto' => 'Tipo Producto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoProducto()
    {
        return $this->hasOne(TiposProductos::className(), ['id' => 'tipo_producto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVentasUsuarios()
    {
        return $this->hasMany(VentasUsuarios::className(), ['producto_id' => 'id']);
    }
}
