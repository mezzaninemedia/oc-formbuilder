<?php

use Mezzanine\FormBuilder\Actions\Email;

class ActionsEmailTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider splitEmailProvider
     */
    public function testSplitEmail($source, $expected)
    {
        $email = new Email();
        $this->assertEquals($expected, $email->splitEmail($source));
    }

    public function splitEmailProvider()
    {
        return array(
            array('"Test Person" <test@person.com>', [['test@person.com', 'Test Person']]),
            array('"Example Somebody" <somebody@example.something>', [['somebody@example.something', 'Example Somebody']]),
            array('"A" <a@a.a>,"B" <b@b.b>', [['a@a.a', 'A'], ['b@b.b', 'B']]),
            array('"A" <a@a.a>, "B" <b@b.b>', [['a@a.a', 'A'], ['b@b.b', 'B']]),
            array('<a@a.a>, "B" <b@b.b>', [['a@a.a', null], ['b@b.b', 'B']]),
            array('a@a.a, "B" <b@b.b>', [['a@a.a', null], ['b@b.b', 'B']]),
            array('', []),
        );
    }
}

