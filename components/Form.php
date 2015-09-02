<?php

namespace Mezzanine\FormBuilder\Components;

use App;
use Request;
use Cms\Classes\ComponentBase;
use Mezzanine\FormBuilder\Models\Form as FormModel;
use Mezzanine\FormBuilder\Models\Field as FieldModel;

class Form extends ComponentBase
{

    private $_values = [];
    private $_saved = false;

    public function componentDetails()
    {
        return [
            'name' => 'Form',
            'description' => 'Display a form',
        ];
    }

    public function defineProperties()
    {
        return [
            'form' => [
                'title' => 'Form',
                'description' => 'Select a form to display',
                'type' => 'dropdown',
                'required' => true,
                'validationMessage' => 'A form is required',
            ],
        ];
    }

    public function fields()
    {
        $id = $this->property('form');
        $fields = FieldModel::where('form_id', $id)->orderBy('sort_order')->get();
        foreach ($fields as $field) {
            $field->setInputValue(isset($this->_values[$field->name]) ? $this->_values[$field->name] : '');
        }
        return $fields;
    }

    public function getFormOptions()
    {
        return FormModel::orderBy('name')->lists('name', 'id');
    }

    public function onRun()
    {
        $form = $this->getForm();
        $request = App::make('request');

        $this->_values = $request->all();

        if ($request->isMethod('post')) {
            $form->runActions($request);
            $this->_saved = true;
            $this->_values = [];
        }
    }

    public function getForm()
    {
        $id = $this->property('form');
        return FormModel::find($id);
    }

    public function isSaved()
    {
        return $this->_saved;
    }
}
