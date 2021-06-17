<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserName */

$this->title = 'Изменение данных пользователя: ' .$model->lastname.' '.$model->firstname;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lastname.' '.$model->firstname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение данных пользователя';
?>
<div class="user-name-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
