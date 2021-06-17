<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Rating */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $arr[7]  = 'Зачет';
    $arr[8]  = 'Не зачет';
    $arr[0] = 'Неявка';
    $arr[5]  = 'Отлично';
    $arr[4]  = 'Хорошо';
    $arr[3]  = 'Удовлетворительно';
    $arr[2]  = 'Неудов.';
?>
<div class="rating-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'teacher_id')->dropDownList(\backend\models\UserName::find()->select(["CONCAT(lastname, ' ', firstname)", 'id'])->where(['status' => 1])->indexBy('id')->column(), ['prompt' => 'Выбрать преподавателя...']) ?>

    <?= $form->field($model, 'subject_id')->dropDownList(\backend\models\Subject::find()->select(["name", 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать дисциплину...']) ?>

    <?= $form->field($model, 'rating')->dropDownList($arr,['prompt'=>'Выбрать...', 'options'=>[ $model['rating'] =>["Selected"=>true]]]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'type_id')->dropDownList(\backend\models\Type::find()->select(["name", 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать тип дисциплины...']) ?>

    <?= $form->field($model, 'student_id')->dropDownList(\backend\models\UserName::find()->select(["CONCAT(lastname, ' ', firstname)", 'id'])->where(['!=','status' , 1])->indexBy('id')->column(), ['prompt' => 'Выбрать студента...']) ?>

    <?= $form->field($model, 'semester')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
