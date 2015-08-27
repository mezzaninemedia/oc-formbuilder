<?php

namespace Mezzanine\FormBuilder\Models;

use Model;

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
        return array_map(function($item) { return $item; }, $this->fields->lists('name'));
    }
}
