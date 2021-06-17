<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\InfForTeacher */

$this->title = 'Добавить преподавателю группу';
$this->params['breadcrumbs'][] = ['label' => 'Преподаватели и их группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inf-for-teacher-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
