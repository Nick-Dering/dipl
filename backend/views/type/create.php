<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Type */

$this->title = 'Добавить тип учебной дисциплины';
$this->params['breadcrumbs'][] = ['label' => 'Типы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
