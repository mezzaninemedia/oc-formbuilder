<?php

namespace Mezzanine\FormBuilder;

use Backend;
use System\Classes\PluginBase;

/**
 * FormBuilder Plugin Information File.
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Form Builder',
            'description' => 'Advanced form builder and action designer',
            'author' => 'Mezzanine Media',
            'icon' => 'icon-circle',
        ];
    }

    public function registerComponents()
    {
        return [
            'Mezzanine\FormBuilder\Components\Form' => 'form',
        ];
    }

    public function registerNavigation()
    {
        return [
            'formbuilder' => [
                'label' => 'Forms',
                'url' => Backend::url('mezzanine/formbuilder/forms'),
                'icon' => 'icon-book',
                'permissions' => ['mezzanine.formbuilder.*'],
                'order' => 500,

                'sideMenu' => [
                    'forms' => [
                        'label' => 'Forms',
                        'icon' => 'icon-book',
                        'url' => Backend::url('mezzanine/formbuilder/forms'),
                        'permissions' => ['mezzanine.formbuilder.access_forms'],
                    ],
                    'fields' => [
                        'label' => 'Fields',
                        'icon' => 'icon-book',
                        'url' => Backend::url('mezzanine/formbuilder/fields'),
                        'permissions' => ['mezzanine.formbuilder.access_fields'],
                    ],
                    'submissions' => [
                        'label' => 'Submissions',
                        'icon' => 'icon-inbox',
                        'url' => Backend::url('mezzanine/formbuilder/submissions'),
                        'permissions' => ['mezzanine.formbuilder.access_submissions'],
                    ],
                ],
            ],
        ];
    }
}
