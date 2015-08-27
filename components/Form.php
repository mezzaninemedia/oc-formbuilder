<?php

namespace Mezzanine\FormBuilder\Components;

use DateTime;
use Log;
use Request;
use Cms\Classes\ComponentBase;
use Mezzanine\FormBuilder\Models\Form as FormModel;
use Mezzanine\FormBuilder\Models\Field as FieldModel;
use Mezzanine\FormBuilder\Models\Submission;

class Form extends ComponentBase
{

    private $_values = [];
    private $_saved = false;
    private $_submission = null;

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
        $availableFields = $form->availableFields();
        $this->_values = Request::only($availableFields);

        if (Request::isMethod('post')) {
            $submission = new Submission();
            $submission->submitted_at = new DateTime();
            $submission->user_agent = Request::header('user-agent');
            $submission->ip_address = Request::ip();
            $submission->referer = Request::header('referer');
            $submission->url = Request::url();
            $submission->raw_input = Request::all();
            $submission->input = $this->_values;
            $submission->save();

            $this->_submission = $submission;
            $this->_saved = true;
            $this->_values = [];
        }
    }

    public function getForm()
    {
        $id = $this->property('form');
        return FormModel::find($id);
    }

    public function isSaved() {
        return $this->_saved;
    }
}
