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
use app\models\Task;
use app\models\TaskForm;
use app\models\Status;

class TaskController extends Controller
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
    
    public function actionIndex($id)
    {
        $project = Project::findOne($id);
        $user = Yii::$app->user->identity;
        $dbQuery = new Query();
        
        $query  = $dbQuery->select([
            'id' => 'task.id',
            'name' => 'task.name',
            'status' => 'status.name',
            'user' => 'user.name'
        ])->from('task')->
            join('LEFT JOIN', 'user', 'user.id = user_id')->
            join('LEFT JOIN', 'status', 'status.id = status_id')->
            where(["=", "task.project_id", $id]);
        
        if ($user['group_id'] !== 1) {
            $query->andWhere(["=", "task.user_id", $user['id']]);
        }
        
        $tasks = $query->orderBy('id')->all();
        
        $TaskMessage = false;

        if (Yii::$app->session->hasFlash('TaskMessage'))
            $TaskMessage = Yii::$app->session->getFlash('TaskMessage');
        
        return $this->render('index', [
            'tasks' => $tasks,
            'project' =>$project,
            'TaskMessage' => $TaskMessage
        ]);
    }
    
    public function actionNew($id)
    {
        $model = new TaskForm();
        
        $status = Status::find()->select(['name', 'id'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post()) && $model->newTask($id)) {
            Yii::$app->session->setFlash('TaskMessage', "Новое задание успешно добавлено!");
            $this->redirect(Url::to(['project/' . $id]), 302)->send();
            return;
        }

        return $this->render('form', [
            'model' => $model,
            'status' => $status,
            'task' => array('project_id' => $id)
        ]);
    }
    
    public function actionEdit($id)
    {
        $model = new TaskForm();
        $task = Task::findOne($id);
        
        $status = Status::find()->select(['name', 'id'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post()) && $model->editTask($task)) {
            Yii::$app->session->setFlash('TaskMessage', "Данные успешно сохранены!");
            $this->redirect(Url::to(['project/' . $task['project_id']]), 302)->send();
            return;
        } else {
            $model->name = $task->name;
            $model->status_id = $task->status_id;
        }

        return $this->render('form', [
            'model' => $model,
            'status' => $status,
            'task' => $task
        ]);
    }
    
    public function actionDelete($id)
    {
        $task = Task::findOne($id);

        if ($task)
            $task->delete();
        
        Yii::$app->session->setFlash('TaskMessage', "Задание успешно удалено!");
        $this->redirect(Url::to(['project/' . $task['project_id']]), 302)->send();
        return;
    }
}
