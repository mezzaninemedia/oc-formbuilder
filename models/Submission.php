<?php

namespace Mezzanine\FormBuilder\Models;

use Model;

/**
 * Submission Model.
 */
class Submission extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'mezzanine_formbuilder_submissions';

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

    protected $jsonable = ['raw_input', 'input'];
}
