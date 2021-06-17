<?php
namespace frontend\controllers;

use backend\models\Rating;
use backend\models\Type;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use backend\models\InfForTeacher;
use backend\models\UserName;
use yii\helpers\VarDumper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $userID;

    public function setUserID(){
        $this->userID = Yii::$app->user->identity->userName[0]->id;
    }

    public function getUserID(){
        $this->setUserID();
        return $this->userID;
    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndexStudent(){
        if (Yii::$app->user->isGuest) {
            return $this->actionLogin();
        }
        $search = ['student_id' => $this->getUserID()];
        $n = mb_substr(Yii::$app->user->identity->userName[0]->group->name, 3,1);
        $items = [
            1 => '1 курс',
            2 => '2 курс',
            3 => '3 курс',
            4 => '4 курс',
            5 => '5 курс',
            6 => 'Все курсы',
        ];
        $arr = [];

        $part = !empty(Yii::$app->request->get('part')) ? $part = Yii::$app->request->get('part') : $n ;

            switch ($part) {
                case 1:
                    $arr = ['<=', 'semester', 2];
                    break;
                case 2:
                    $arr = ['or',
                    ['semester' => 3],
                    ['semester' => 4]
                    ];
                    break;
                case 3:
                    $arr = ['or',
                        ['semester' => 5],
                        ['semester' => 6]
                    ];
                    break;
                case 4:
                    $arr = ['or',
                        ['semester' => 7],
                        ['semester' => 8]
                    ];
                    break;
                case 5:
                    $arr = ['or',
                        ['semester' => 9],
                        ['semester' => 10]
                    ];
                    break;
            }


        $model = Rating::find()
            ->with(['teacher', 'type', 'subject'])
            ->where($search)
            ->andWhere($arr)
            ->orderBy(['rating.semester' => SORT_ASC])
            ->asArray()->all();

//        VarDumper::dump(Yii::$app->user->identity->userName[0]->group->name, 10, true );
//        VarDumper::dump($model, 10, true );

        return $this->render('index-student',[
            'model' => $model, 'items' => $items, 'n' => $part
        ]);
    }

    public function actionIndex()
    {
        if(Yii::$app->user->identity->userName[0]->status != 1) return $this->actionIndexStudent();

        $model = InfForTeacher::find()
        ->with(['subject', 'group'])
        ->where(['inf_for_teacher.user_id' => $this->getUserID(), 'inf_for_teacher.status' => 0])
        ->asArray()->all();

        $groups = [];

        foreach ($model as $key => $m){
            $groups[$m['group']['name']]['id'] = $m['group']['id'];
            $groups[$m['group']['name']]['subject'][$key] = ['id' => $m['subject']['id'],'name' => $m['subject']['name'], 'semester' => $m['semester']];
        }

//        VarDumper::dump($groups, 10, true );
//        VarDumper::dump($model, 10, true );

        return $this->render('index',[
            'groups' => $groups
        ]);
    }

    public function actionStudents($subject = null, $semester = null)
    {
        $flag = false;

        $userID = $this->getUserID();
        $request = Yii::$app->request;
        $ratPost = $request->post('Rating');

        if(!empty($ratPost)) {

            foreach ($ratPost as $r) {
                $rating = Rating::findOne($r['id']);
                if($rating != null) {
                    $rating->date = date("Y-m-d H:i:s");
                    $rating->rating = $r['rating'];
                    if ($rating->save()) $flag = true;
                }
            }
            if (!$flag) return "Error save";

        }

        if(!isset($userID)) return $this->goHome();

        if($subject == null || $semester === null) return $this->goHome();

        $model = Rating::find()
            ->joinWith(['student.group', 'subject', 'type'])
            ->where(['subject_id' => $subject, 'semester' => $semester, 'teacher_id' => $userID])
            ->orderBy(['user_name.lastname' => SORT_ASC])
            ->all();

        if(!empty($model)) {
            $variants = [];

            if($model[0]['type_id']){
                $type = Type::findOne($model[0]['type_id']);
                $variants = $type->getVariant();
            }
//            var_dump($variants);

            if(empty($variants)) $this->goBack();

            return $this->render('students',[
                'model' => $model, 'variants' => $variants, 'flag' => $flag
            ]);
        }

        return $this->goBack();

    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $session = Yii::$app->session;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = UserName::find()->where(['user_id' => Yii::$app->user->id])->one();
            $session->set('userId', $user->id);
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {

        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
