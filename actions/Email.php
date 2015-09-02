<?php

namespace Mezzanine\FormBuilder\Actions;

use Mail;
use Mezzanine\FormBuilder\Models\Submission;
use System\Models\MailTemplate;

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
            'data[subject]' => ['label' => 'Subject', 'type' => 'text'],
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
        $to = $this->field->data['to'];
        $from = $this->field->data['from'];
        $template = $this->field->data['mail_template'];

        Mail::send($template, $submission->input, function ($message) use ($from, $to) {
            $message->from($from);
            $message->to($to);
        });
    }
}
