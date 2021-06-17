<?php

/* @var $this yii\web\View */
/* @var $groups yii\web\View */
/* @var $model yii\web\View */
/* @var $items yii\web\View */
/* @var $n yii\web\View */

$this->title = 'Кабинет студента';

use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Rating;

?>
<div class="container">

    <h2>
        <small>Вы вошли как</small>
        <br>
        <?= Yii::$app->user->identity->userName[0]->fio; ?>
    </h2>
    <hr>
    <h3>
        <?= Yii::$app->user->identity->userName[0]->specialty->name?> 
        <br>
        Группа <?= Yii::$app->user->identity->userName[0]->group->name ?>
    </h3>
    <br>

    <?= Html::beginForm(['site/index-student'], 'get' ); ?>
    <div class="form-group">

        <h4><b>Курс: </b></h4>
        <div class="input-group-btn">
            <div class="col-auto my-1">

                <?= Html::dropDownList('part', 'null', $items, ['class' => 'form-control', 'options'=>[ $n =>["Selected"=>true]]]) ?>
            </div>
        </div>
        <div class="input-group-btn" style="padding: 0 0 0 5px;">
            <div class="col-auto my-1">
                <?= Html::submitButton('Выбрать', ['type' => 'button', 'class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?= Html::endForm() ?>


    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Семестр</th>
            <th>Дисциплина</th>
            <th>Тип</th>
            <th>Оценка</th>
            <th>Преподаватель</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($model as $m): ?>
            <tr>
                <td>
                    <?= $m['semester'] ?>
                </td>
                <td>
                    <?= $m['subject']['name'] ?>
                </td>
                <td>
                    <?= $m['type']['name'] ?>
                </td>
                <td>
                    <?= Rating::getTypeRating($m['rating']) ?>
                </td>
                <td>
                    <?= $m['teacher']['lastname'] . ' ' . $m['teacher']['firstname'] . ' ' . $m['teacher']['patronymic'] ?>
                </td>
                <td>
                    <?= date_format(date_create($m['date']), 'd.m.Y') ?>
                </td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
</div>
