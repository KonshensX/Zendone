<?php

class Application_Form_Register extends Zend_Form {

    public function init () {
        $this->setAttrib('id', 'registerForm');
        $this->setMethod('POST');
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email');
        $email->setAttribs([
            'class' => 'form-control',
            'required' => 'required'
        ]);
        $email->addValidator(new Zend_Validate_EmailAddress());
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username');
        $username->setAttribs([
            'class' => 'form-control',
            'required' => 'required'
        ]);
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password');
        $password->setAttribs([
            'class' => 'form-control',
            'required' => 'required'
        ]);
        $confirmPassword = new Zend_Form_Element_Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password');
        $confirmPassword->setAttribs([
            'class' => 'form-control',
            'required' => 'required'
        ]);
        
        $this->addElements([
            $username,
            $email,
            $password,
            $confirmPassword,
        ]);
    }

}