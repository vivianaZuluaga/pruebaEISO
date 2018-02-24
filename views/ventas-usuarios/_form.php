<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Productos;
use app\models\Ciudades;

/* @var $this yii\web\View */
/* @var $model app\models\VentasUsuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ventas-usuarios-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'fecha_venta')->widget(DatePicker::className(), [
		'language' => 'es',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
	]);?>

	<?= $form->field($model, 'producto_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Productos::find()->All(), 'id', 'nombre'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione un producto'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        ])->label('Producto');
    ?>

    <?= $form->field($model, 'ciudad')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Ciudades::find()->All(), 'id', 'nombre_municipio'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una ciudad'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        ]);
    ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
