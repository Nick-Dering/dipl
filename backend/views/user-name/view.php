<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserName */

$this->title =  $model->lastname.' '.$model->firstname.' '. $model->patronymic;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-name-view">

    <h1><?= Html::encode($this->title) ?> 
        <small>
            <? 
            if ($model->status == 0)
                echo "Студент";
            else 
                echo "Преподаватель"; 
            ?>
        </small>
    </h1>
    <hr>

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

    <h3 style="line-height:1.5">
        <?= $model->specialty->name ?> <br>
        <?= $model->group->name ?> <br>
    </h3>


    <? /* DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'firstname',
            'lastname',
            'patronymic',
            'status',
            'group_id',
            'specialty_id',
        ],
    ]) */ ?>

</div>
