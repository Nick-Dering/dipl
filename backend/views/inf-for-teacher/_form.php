<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\InfForTeacher */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inf-for-teacher-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(\backend\models\UserName::find()->select(["CONCAT(lastname, ' ', firstname, ' ', patronymic)", 'id'])->where(['status' => 1])->indexBy('id')->column(), ['prompt' => 'Выбрать преподавателя...']) ?>

    <?= $form->field($model, 'group_id')->dropDownList(\backend\models\Groups::find()->select(["name", 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать группу...']) ?>

    <?= $form->field($model, 'subject_id')->dropDownList(\backend\models\Subject::find()->select(["name", 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать дисциплину...']) ?>

    <?= $form->field($model, 'type_id')->dropDownList(\backend\models\Type::find()->select(["name", 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать тип дисциплины...']) ?>

    <?= $form->field($model, 'semester')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([
            '0' => 'Активный',
            '1' => 'Отключен',
            '2'=>'Удален'
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
