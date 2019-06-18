<?php

namespace app\models;

use Yii;
use yii\base\Model;

class TaskForm extends Model
{
    public $name, $status_id;

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required', "message" => "Введите название задания!"],
            ['status_id', 'integer'],
            ['status_id', 'required', "message" => "Выберите статус!"]
        ];
    }

    public function newTask($id)
    {
        if ($this->validate()) {
            $task = new Task();
            $user = Yii::$app->user->identity;
            $task->name = $this->name;
            $task->project_id = $id;
            $task->status_id = $this->status_id;
            $task->user_id = $user['id'];
            $task->save();
            return true;
        }
        
        return false;
    }

    public function editTask($task)
    {
        if ($this->validate()) {
            $task->name = $this->name;
            $task->status_id = $this->status_id;
            $task->save();
            return true;
        }
        
        return false;
    }
}
