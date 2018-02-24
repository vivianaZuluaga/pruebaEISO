<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VentasUsuarios */

$this->title = 'Create Ventas Usuarios';
$this->params['breadcrumbs'][] = ['label' => 'Ventas Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ventas-usuarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
