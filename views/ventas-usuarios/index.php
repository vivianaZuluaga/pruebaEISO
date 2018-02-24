<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VentasUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ventas Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ventas-usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ventas Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'usuario_id',
                'value' => 'usuario.nombre',
            ],
            [
                'attribute' => 'producto_id',
                'value' => 'producto.nombre',
            ],
            'cantidad',
            [
                'attribute' => 'fecha_venta',
                'value' => 'fecha_venta',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'fecha_venta',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]),
            ],
            [
                'attribute' => 'ciudad',
                'value' => 'ciudad0.nombre_municipio',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
