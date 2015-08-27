<?php

namespace Mezzanine\FormBuilder\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Submissions Back-end Controller.
 */
class Submissions extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Mezzanine.FormBuilder', 'formbuilder', 'submissions');
    }
}
