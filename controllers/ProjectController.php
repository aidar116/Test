<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\filters\AccessControl;
use app\components\AdminControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\models\User;
use app\models\Project;
use app\models\ProjectForm;

class ProjectController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'new'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
            'admin' => [
                'class' => AdminControl::className(),
                'only' => ['delete', 'edit']
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'get']
                ],
            ],
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
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
	public function actionNew()
    {
        $model = new ProjectForm();

        if ($model->load(Yii::$app->request->post()) && $model->newProject()) {
            Yii::$app->session->setFlash('ProjectMessage', "Новый проект успешно добавлен!");
            $this->redirect(Url::to(['/']), 302)->send();
            return;
        }

        return $this->render('form', [
            'model' => $model
        ]);
    }
    
    public function actionEdit($id)
    {
        $model = new ProjectForm();
        
        $project = Project::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->editProject($project)) {
            Yii::$app->session->setFlash('ProjectMessage', "Данные успешно сохранены!");
            $this->redirect(Url::to(['/']), 302)->send();
            return;
        } else {
            $model->name = $project->name;
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id)
    {
        $project = Project::findOne($id);

        if ($project)
            $project->delete();
        
        Yii::$app->session->setFlash('ProjectMessage', "Проект успешно удален!");
        $this->redirect(Url::to(['/']), 302)->send();
        return;
    }
}
