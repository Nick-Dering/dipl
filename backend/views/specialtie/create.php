<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Specialties */

$this->title = 'Добавить специальность';
$this->params['breadcrumbs'][] = ['label' => 'Специальность', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="specialties-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
