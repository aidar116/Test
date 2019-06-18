<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ProjectForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required', "message" => "Введите название проекта!"]
        ];
    }

    public function newProject()
    {
        if ($this->validate()) {
            $project = new Project();
            $project->name = $this->name;
            $project->save();
            return true;
        }
        
        return false;
    }

    public function editProject($project)
    {
        if ($this->validate()) {
            $project->name = $this->name;
            $project->save();
            return true;
        }
        
        return false;
    }
}
