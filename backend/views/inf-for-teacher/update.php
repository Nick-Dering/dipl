<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\InfForTeacher */

$this->title = 'Изменить связь преподавателя с группой ' . $model->group->name;
$this->params['breadcrumbs'][] = ['label' => 'Преподаватели и их группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Назад', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="inf-for-teacher-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
