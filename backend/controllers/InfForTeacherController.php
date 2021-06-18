<?php

namespace backend\controllers;

use backend\models\Rating;
use backend\models\UserName;
use Yii;
use backend\models\InfForTeacher;
use backend\models\search\InfForTeacherSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InfForTeacherController implements the CRUD actions for InfForTeacher model.
 */
class InfForTeacherController extends SiteController
{
    /**
     * {@inheritdoc}
     */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

    /**
     * Lists all InfForTeacher models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new InfForTeacherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InfForTeacher model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InfForTeacher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InfForTeacher();

        $this->saveModel($model);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing InfForTeacher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->saveModel($model);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing InfForTeacher model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InfForTeacher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InfForTeacher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InfForTeacher::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function saveModel($model){
        // проверка на отправку данных
        if($model->load(Yii::$app->request->post())) {

            $array = [
                $model->user_id,
                $model->subject_id,
                $model->semester,
                $model->type_id,
            ];

            try {
                if($this->generateRating($model->group_id, $array)){
                    if($model->save()) return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        return true;
    }

    protected function generateRating($group_id = null, $array = [])
    {
        if($group_id === null) throw new Exception('Группа нет передана!');

        $user = UserName::find()->select("id")->where(['group_id' => $group_id])->asArray()->all();

        if(empty($user)) throw new Exception('У группы нет студентов!');

        if(!empty($array)) {


            $flag = true;
            foreach ($user as $u) {
                // проверка что в рэйтинге уже есть студент, для которого уже выставлены оценки
                $rating = Rating::find()->where([
                    'teacher_id' => $array[0],
                    'subject_id' => $array[1],
                    'semester' => $array[2],
                    'student_id' => $u["id"],
                    'type_id' => $array[3]
                ])->one();
                if ($rating != null) continue;
                $model = new Rating();
                $model->teacher_id = $array[0];
                $model->subject_id = $array[1];
                $model->rating = null;
                $model->date = date("Y-m-d H:i:s");
                $model->type_id = $array[3];
                $model->student_id = $u["id"];
                $model->semester = $array[2];
                if (!$model->save()) $flag = false;
            }

            return $flag;

        }else{
            throw new Exception('Пустой массив параметров!');
        }

    }
}
