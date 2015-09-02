<?php

namespace Mezzanine\FormBuilder\Models;

use Model;
use Mezzanine\FormBuilder\Classes\Actions;

/**
 * Action Model.
 */
class Action extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'mezzanine_formbuilder_actions';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'form' => [
            'Mezzanine\FormBuilder\Models\Form',
            'key' => 'form_id',
        ],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    protected $jsonable = ['data', 'conditions'];

    public function getTypeOptions()
    {
        $actions = new Actions($this);
        return $actions->getActionNames();
    }

    /**
     * Customisation of displayed fields based on the action type.
     */
    public function getCustomFields()
    {
        $action = $this->getAction();
        return $action ? $action->getCustomFields() : [];
    }

    public function getAction()
    {
        if ($this->type) {
            $actions = new Actions();
            $actionName = $actions->listRawActions()[$this->type];
            return new $actionName($this);
        }
    }

    public function filterFields($fields)
    {
        if ($this->type) {
            $fields->sort_order->hidden = true;
            $fields->type->disabled = true;
        }
    }

    public function processSubmission(Submission $submission)
    {
        $this->getAction()->processSubmission($submission);
    }
}
