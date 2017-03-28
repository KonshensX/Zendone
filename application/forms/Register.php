<?php

class Application_Form_Register extends Zend_Form {

    public function init () {
        $this->setMethod('POST');
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email');
        $email->setAttribs([
            'class' => 'form-control'
        ]);
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username');
        $username->setAttribs([
            'class' => 'form-control'
        ]);
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password');
        $password->setAttribs([
            'class' => 'form-control'
        ]);
        $confirmPassword = new Zend_Form_Element_Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password');
        $confirmPassword->setAttribs([
            'class' => 'form-control'
        ]);
        
        $this->addElements([
            $username,
            $email,
            $password,
            $confirmPassword,
        ]);
    }

}