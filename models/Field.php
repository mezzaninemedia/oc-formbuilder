<?php

namespace Mezzanine\FormBuilder\Models;

use Model;

/**
 * Field Model.
 */
class Field extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'mezzanine_formbuilder_fields';

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

    protected $inputValue = '';

    public function setInputValue($value) {
        $this->inputValue = $value;
    }

    public function value() {
        return $this->inputValue;
    }
}
