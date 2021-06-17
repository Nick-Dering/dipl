<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Rating */

$this->title = 'Оценка';
$this->params['breadcrumbs'][] = ['label' => 'Список оценок', 'url' => ['index']];
\yii\web\YiiAsset::register($this);

$arr[7] = 'Зачет';
$arr[1] = 'Нет данных';
$arr[8] = 'Не зачет';
$arr[0] = 'Неявка';
$arr[5] = 'Отлично';
$arr[4] = 'Хорошо';
$arr[3] = 'Удовлетворительно';
$arr[2] = 'Неудов.';

?>
<div class="rating-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p class="lead" style="line-height:1.5">
        ID оценки: <?= $model->id ?> <br>
        Оценка студента: <?= $model->student->fio ?> <br>
        Преподаватель: <?= $model->teacher->fio ?> <br>
        Дисциплина: <?= $model->subject->name ?> <br>
        Тип дисциплины: <?= $model->type->name ?> <br>
        Оценка: <?= $model->getTypeRating($model->rating); ?> <br>
        Дата: <?= $model->date ?> <br>
    </p>
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

    <? /* DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'teacher_id',
            'subject_id',
            'rating',
            'date',
            'type_id',
            'student_id',
            'semester',
        ],
    ]) */?>



</div>
