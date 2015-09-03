<?php

namespace Mezzanine\FormBuilder\Actions;

use Mail;
use Mezzanine\FormBuilder\Models\Submission;
use System\Models\MailTemplate;
use Twig_Loader_Array;
use Twig_Environment;

class Email extends ActionBase
{
    protected $name = 'Send Email';
    protected $description = 'Send an email with the submitted response';
    protected $author = 'Mezzanine Media';

    public function getCustomFields()
    {
        return [
            'data[mail_template]' => [
                'label' => 'Mail Template',
                'type' => 'dropdown',
                'options' => $this->getMailTemplateValues()
            ],
            'data[to]' => ['label' => 'To', 'type' => 'text'],
            'data[cc]' => ['label' => 'CC', 'type' => 'text'],
            'data[bcc]' => ['label' => 'BCC', 'type' => 'text'],
            'data[from]' => ['label' => 'From', 'type' => 'text'],
        ];
    }

    public function getMailTemplateValues()
    {
        $results = [];
        foreach (MailTemplate::all() as $template) {
            $results[$template->code] = $template->code . ' - ' . $template->description;
        }
        return $results;
    }

    public function processSubmission(Submission $submission)
    {
        $fields = $this->interpolate($this->field->data, $submission->input);
        $to = $this->splitEmail($fields['to']);
        $cc = $this->splitEmail($fields['cc']);
        $bcc = $this->splitEmail($fields['bcc']);
        $from = $this->splitEmail($fields['from']);
        $template = $fields['mail_template'];

        Mail::send($template, $submission->input, function ($message) use ($to, $cc, $bcc, $from) {
            foreach ($to as $item) $message->to($item[0], $item[1]);
            foreach ($cc as $item) $message->cc($item[0], $item[1]);
            foreach ($bcc as $item) $message->bcc($item[0], $item[1]);
            foreach ($from as $item) $message->from($item[0], $item[1]);
        });
    }

    public function interpolate($templates, $params)
    {
        $loader = new Twig_Loader_Array($templates);
        $twig = new Twig_Environment($loader);
        $results = [];
        foreach ($templates as $key => $value) {
            $results[$key] = $twig->render($key, $params);
        }
        return $results;
    }

    public function splitEmail($source)
    {
        if (empty(trim($source))) return [];
        $rawPeople = explode(',', $source);
        $result = [];
        foreach ($rawPeople as $person) {
            $result[] = $this->splitSingleEmail($person);
        }
        return $result;
    }

    protected function validateEmail($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
    }

    function splitSingleEmail($str)
    {
        $str .= ' ';
        $sPattern = '/([\w\s\'\"]+[\s]+)?(<)?(([\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]+))?(>)?/';
        preg_match($sPattern, $str, $aMatch);
        $name = trim((isset($aMatch[1])) ? $aMatch[1] : '', " \t\n\r\0\x0B'\"");
        $email = trim((isset($aMatch[3])) ? $aMatch[3] : '');
        return empty($name) ? [$email, null] : [$email, $name];
    }

}
