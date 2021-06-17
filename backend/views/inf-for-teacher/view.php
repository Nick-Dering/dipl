<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\InfForTeacher */

$this->title = $model->group->name.' - '.$model->user->fio.' - '.$model->subject->name.': семестр '.$model->semester;
$this->params['breadcrumbs'][] = ['label' => 'Преподаватели и их группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inf-for-teacher-view">

    <h3 style="line-height:1.5">
        Преподаватель: <?= $model->user->fio ?> <br>
        Ведет у группы: <?= $model->group->name ?> <br>
        Дисциплина: <?= $model->subject->name ?> |
        <?= $model->type->name ?> <br>

        Семестр: <?= $model->semester ?>
    </h3>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <? /* echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'group_id',
            'subject_id',
            'type_id',
            'semester',
            'status',
        ],
    ]) */ ?>

</div>
