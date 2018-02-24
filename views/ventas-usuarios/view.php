<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VentasUsuarios */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ventas Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ventas-usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Usuario',
                'value' => $model->usuario->nombre,
            ],
            [
                'label' => 'Producto',
                'value' => $model->producto->nombre,
            ],
            'cantidad',
            'fecha_venta',
            'valor',
            [
                'label' => 'Ciudad',
                'value' => $model->ciudad0->nombre_municipio,
            ],
        ],
    ]) ?>

</div>
