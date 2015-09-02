<?php

namespace Mezzanine\FormBuilder\Fields;

class FieldBase
{
    protected $name = '';
    protected $description = '';
    protected $author = '';

    public function fieldDetails()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'author' => $this->author,
        ];
    }
}
