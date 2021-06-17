<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Rating */

$this->title = 'Добавить оценку';
$this->params['breadcrumbs'][] = ['label' => 'Оценки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rating-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
