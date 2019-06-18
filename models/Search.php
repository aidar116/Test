<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;

class Search extends Model
{
    public $dbQuery, $query, $result, $name, $status;

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required', "message" => "Введите название"],
            ['status', 'string']
        ];
    }

    public function newSearch()
    {
        $dbQuery = new Query();
        $query  = $dbQuery->select([
            'id' => 'task.id',
            'name' => 'task.name',
            'status' => 'status.name',
            'user' => 'user.name',
            'project' => 'project.name'
        ])->from('task')->
            join('LEFT JOIN', 'user', 'user.id = user_id')->
            join('LEFT JOIN', 'status', 'status.id = status_id')->
            join('LEFT JOIN', 'project', 'project.id = project_id')->
        where('task.name like :name', [':name' => "%" . $this->name . "%"])->
        andwhere(["=", "task.user_id", $user = Yii::$app->user->identity->id]);
        
        if ($this->status)
            $query->andwhere(["=", "task.status_id", $this->status]);
		print_r($this->status);
        $result = $query->orderBy(['id' => SORT_DESC])->all();
        
        return $result;
    }
}