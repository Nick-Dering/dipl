<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserNameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-name-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'user_id',
            ['attribute' => 'lastname','label' => 'Фамилия', 'value'=>'lastname'],
            ['attribute' => 'firstname','label' => 'Имя', 'value'=>'firstname'],
            ['attribute' => 'patronymic','label' => 'Отчество', 'value'=>'patronymic'],

            ['attribute' => 'status', 'label' => 'Статус', 'value' => function($data) {
                return $data->status === 0 ? 'Студент' : 'Преподаватель';
            }],        
    
            //'status',
            ['attribute' => 'group_id','label' => 'Группа', 'value'=>'group.name'],            
            //'specialty_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
