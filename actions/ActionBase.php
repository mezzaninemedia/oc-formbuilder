<?php

namespace Mezzanine\FormBuilder\Actions;

use Mezzanine\FormBuilder\Models\Submission;

class ActionBase
{
    protected $name = '';
    protected $description = '';
    protected $author = '';

    protected $field;

    public function __construct($field = null)
    {
        $this->field = $field;
    }

    public function actionDetails()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'author' => $this->author,
        ];
    }

    public function getActionName()
    {
        return $this->actionDetails()['name'];
    }

    public function getCustomFields()
    {
        return [];
    }

    public function processSubmission(Submission $submission)
    {
    }
}
