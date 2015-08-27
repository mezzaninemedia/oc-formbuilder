<?php

namespace Mezzanine\FormBuilder\Models;

use Model;

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
    protected $guarded = ['*'];

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
}
