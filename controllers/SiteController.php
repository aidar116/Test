<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\db\Query;
use app\components\AdminControl;
use app\models\User;
use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\Project;
use app\models\Search;
use app\models\Status;

class SiteController extends Controller
	{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'admin' => [
                'class' => AdminControl::className(),
                'only' => ['adminer']
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'get']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Project::find();

        $project = $query->orderBy('id')->all();

        $ProjectMessage = false;

        if (Yii::$app->session->hasFlash('ProjectMessage'))
            $ProjectMessage = Yii::$app->session->getFlash('ProjectMessage');
        
        return $this->render('index', [
            'project' => $project,
            'ProjectMessage' => $ProjectMessage
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login())
            return $this->goBack();
        
        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
    /**
     * Registration action.
     *
     * @return string
     */
	public function actionRegistration()
    {
        $model = new RegistrationForm();

        $RegMessage = false;

        if ($model->load(Yii::$app->request->post()) && $model->registration()) {
            Yii::$app->session->setFlash('RegMessage', "Регистрация прошла успешно!");
            $this->redirect(Url::to(['/registration']), 302)->send();
            return;
        }

        if (Yii::$app->session->hasFlash('RegMessage'))
            $RegMessage = Yii::$app->session->getFlash('RegMessage');
        
        return $this->render('registration', [
            'model' => $model,
            'RegMessage' => $RegMessage
        ]);
    }
    
    public function actionAdminer()
    {
        $user = Yii::$app->user->identity;
        
        $dbQuery = new Query();
        $query  = $dbQuery->select([
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'status' => 'status'
        ])->from('user')->
            where(["=", "status", 0])->
            andWhere(["!=", "id", $user['id']]);
        
        $users = $query->orderBy('id')->all();
        
        $AdminerMessage = false;

        if (Yii::$app->session->hasFlash('AdminerMessage'))
            $AdminerMessage = Yii::$app->session->getFlash('AdminerMessage');
        
        return $this->render('adminer', [
            'users' => $users,
            'AdminerMessage' => $AdminerMessage
        ]);
    }
    
    public function actionBan($id)
    {
        $user = User::findOne($id);

        if ($user) {
            $user->status = 1;
            $user->save();
        }
        
        Yii::$app->session->setFlash('AdminerMessage', "Пользователю установлен бан");
        $this->redirect(Url::to(['/adminer']), 302)->send();
        return;
    }
    
    public function actionDelete($id)
    {
        $user = User::findOne($id);

        if ($user)
            $user->delete();
        
        Yii::$app->session->setFlash('AdminerMessage', "Пользователь успешно удален!");
        $this->redirect(Url::to(['/adminer']), 302)->send();
        return;
    }
    
    public function actionSearch()
    {
        $model = new Search();
        
        $status = Status::find()->select(['name', 'id'])->indexBy('id')->column();
        array_unshift($status, "Все");
        
        $model->load(Yii::$app->request->post());
        
        Yii::$app->session->setFlash('InfoMessage', "Поиск не дал результатов!");
        
        $InfoMessage = false;

        if (Yii::$app->session->hasFlash('InfoMessage'))
            $InfoMessage = Yii::$app->session->getFlash('InfoMessage');
        
        return $this->render('search', [
            'model' => $model,
            'InfoMessage' => $InfoMessage,
            'result' => $model->newSearch(),
            'status' => $status
        ]);
    }
}