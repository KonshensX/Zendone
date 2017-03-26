<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username')
            ->setAttribs([
                'class' => 'form-control'
            ]);

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
            ->setAttribs([
                'class' => 'form-control'
            ]);

        $this->addElements([$username, $password]);
    }


}

