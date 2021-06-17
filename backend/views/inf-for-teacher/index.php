<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\InfForTeacherSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Преподаватели и группы у которых они ведут';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inf-for-teacher-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <p>
        <?= Html::a('Добавить преподавателю группу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user_id',
                'filter' => \backend\models\UserName::find()->select(["CONCAT(lastname, ' ', firstname)", 'id'])->where(['status' => 1])->indexBy('id')->column(),
                'label' => 'Преподаватель',
                'value'=>'user.fio'
            ],

            ['attribute' => 'group_id','label' => 'Группа', 'value'=>'group.name'],
            ['attribute' => 'subject_id','label' => 'Дисциплина', 'value'=>'subject.name',
                'filter' => \backend\models\Subject::find()->select(["name", 'id'])->indexBy('id')->column(),
                ],
            ['attribute' => 'type_id','label' => 'Тип дисциплины', 'value'=>'type.name',
                'filter' => \backend\models\Type::find()->select(["name", 'id'])->indexBy('id')->column(),
                ],
            'semester',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
