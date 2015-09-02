<?php

namespace Mezzanine\FormBuilder\Controllers;

use Log;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Forms Back-end Controller.
 */
class Forms extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Mezzanine.FormBuilder', 'formbuilder', 'forms');
    }

    public function create()
    {
        $this->bodyClass = 'compact-container';

        return $this->asExtension('FormController')->create();
    }

    public function update($recordId = null)
    {
        $this->bodyClass = 'compact-container';
        $this->addCss('/plugins/mezzanine/formbuilder/assets/css/reorder.css');
        $this->addJs('/plugins/mezzanine/formbuilder/assets/js/reorder.js');

        return $this->asExtension('FormController')->update($recordId);
    }

    // public function formExtendFields($form)
    // {
    //     Log::info(get_object_vars($form));
    //     // Log::info(get_class($model));
    //     // Log::info(get_class($context));
    //     // $form->addFields([...]);
    // }

}
