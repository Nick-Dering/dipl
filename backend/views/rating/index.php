<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\UserName;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RatingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Оценки';
$this->params['breadcrumbs'][] = $this->title;


$arr[7] = 'Зачет';
$arr[1] = 'Нет данных';
$arr[8] = 'Не зачет';
$arr[0] = 'Неявка';
$arr[5] = 'Отлично';
$arr[4] = 'Хорошо';
$arr[3] = 'Удовлетворительно';
$arr[2] = 'Неудов.';

?>
<div class="rating-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить оценку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute' => 'teacher_id', 'label' => 'Преподаватель', 'value' => 'teacher.fio',
            //                'filter' =>  UserName::find()->where(['status' => 1])->select(["CONCAT(lastname, ' ', firstname)", 'id'])->indexBy('id')->column(),
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'teacher_id',
                    'data' => \yii\helpers\ArrayHelper::map(UserName::find()->where(['=', 'status', 1])->all(), 'id', 'fio'),
                    'value' => 'teacher.fio',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'selectOnClose' => true,
                    ]
                ]),
            ],
            ['attribute' => 'subject_id','label' => 'Предмет', 'value'=>'subject.name',
                'filter' => \backend\models\Subject::find()->select(["name", 'id'])->indexBy('id')->column(),
                ],

            ['attribute' => 'type_id','label' => 'Тип дисциплины', 'value'=>'type.name',
                'filter' => \backend\models\Type::find()->select(["name", 'id'])->indexBy('id')->column(),
            ],
            ['attribute' => 'student_id', 'label' => 'Студент', 'value' => 'student.fio',
            //                'filter' => \backend\models\UserName::find()->where(['!=', 'status', 1])->select(["CONCAT(lastname, ' ', firstname)", 'id'])->indexBy('id')->column(),
                'filter' => \kartik\select2\Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'student_id',
                    'data' => \yii\helpers\ArrayHelper::map(UserName::find()->where(['!=', 'status', 1])->all(), 'id', 'fio'),
                    'value' => 'student.fio',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'selectOnClose' => true,
                    ]
                ]),
            ],
            'semester',
            ['attribute' => 'rating','label' => 'Оценка', 'value' => function ($data) {
                if($data->rating === null) $data->rating = 1;
                return $data->getTypeRating($data->rating); },
                'filter' => $arr,
                ],
//            'filter' => $arr,
            ['attribute' => 'date', 'value' => function($m) {
                return date_format(date_create($m['date']), 'd.m.Y');
            }],



            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
