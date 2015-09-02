<?php

namespace Mezzanine\FormBuilder\Classes;

use Event;

class Actions
{
    public function listRawActions()
    {
        $actions = Event::fire('mezzanine.formbuilder.listActionTypes');
        $actions = $this->flatten($actions);
        return $actions;
    }

    public function listActions()
    {
        $actions = array_map(function ($className) {
            return new $className();
        }, $this->listRawActions());
        return $actions;
    }

    public function flatten($array)
    {
        $array = is_array($array) ? $array : [];

        return array_reduce($array, 'array_merge', []);
    }

    public function getAction($actionId)
    {
        return $this->listActions()[$actionId];
    }

    public function getActionName($actionId)
    {
        return $this->getAction($actionId)->getActionName();
    }

    public function getActionNames()
    {
        $result = [];
        foreach ($this->listActions() as $key => $class) {
            $result[$key] = $class->actionDetails()['name'];
        };
        return $result;
    }
}
