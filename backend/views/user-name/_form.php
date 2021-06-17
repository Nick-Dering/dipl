<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserName */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-name-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->label('ID пользователя')->dropDownList(\common\models\User::find()->select(["username", 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать пользователя...']) ?>

    <?= $form->field($model, 'firstname')->label('Имя')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->label('Фамилия')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->label('Отчество')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->label('Статус (преподаватель/студент)')->dropDownList([
        '0' => 'Студент',
        '1' => 'Преподаватель',
    ]); ?>
    
    <?= $form->field($model, 'group_id')->dropDownList(\backend\models\Groups::find()->select(["name", 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать группу...']) ?>

    <?= $form->field($model, 'specialty_id')->dropDownList(\backend\models\Specialties::find()->select(["name", 'id'])->indexBy('id')->column(), ['prompt' => 'Выбрать специальность...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
