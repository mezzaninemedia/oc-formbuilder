<?php

namespace Mezzanine\FormBuilder\Models;

use Model;
use DateTime;

/**
 * Form Model.
 */
class Form extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'mezzanine_formbuilder_forms';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'fields' => [
            'Mezzanine\FormBuilder\Models\Field',
            'order' => 'sort_order',
            'delete' => true,
        ],
        'actions' => [
            'Mezzanine\FormBuilder\Models\Action',
            'order' => 'sort_order',
            'delete' => true,
        ],
    ];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function availableFields()
    {
        return array_map(function ($item) {
            return $item;
        }, $this->fields->lists('name'));
    }

    public function runActions($request)
    {
        $submission = $this->saveSubmission($request);
        $actions = Action::where('form_id', $this->id)->orderBy('sort_order')->get();
        foreach ($actions as $action) {
            $action->processSubmission($submission);
        }
    }

    public function saveSubmission($request)
    {
        $availableFields = $this->availableFields();
        $submission = new Submission([
            'form_id' => $this->id,
            'submitted_at' => new DateTime(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('user-agent'),
            'referer' => $request->header('referer'),
            'url' => $request->url(),
            'raw_input' => $request->all(),
            'input' => $request->only($availableFields),
        ]);
        $submission->save();
        return $submission;
    }
}
