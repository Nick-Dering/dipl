<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Rating */

$this->title = 'Изменить оценку';
$this->params['breadcrumbs'][] = ['label' => 'Оценки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Выбранная оценка', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="rating-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
