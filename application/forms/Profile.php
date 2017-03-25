<?php

class Application_Form_Profile extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $id = new Zend_Form_Element_Hidden('id');

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username')
            ->setAttribs(array(
                'class' => 'form-control',
            ));

        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname->setLabel('First name')
            ->setAttribs(array(
                'class' => 'form-control',

            ));

        $lastname = new Zend_Form_Element_Text('lastname');
        $lastname->setLabel('Last name')
            ->setAttribs([
                'class' => 'form-control'
            ]);

        $phone = new Zend_Form_Element_Text('mobile');
        $phone->setLabel('mobile')
            ->setAttribs([
                'class' => 'form-control'
            ]);

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
            ->setAttribs([
                'class' => 'form-control'
            ]);

        $interests = new Zend_Form_Element_Text('interests');
        $interests->setLabel('Interests')
            ->setAttribs([
                'class' => 'form-control'
            ]);

        $occupation = new Zend_Form_Element_Text('occupation');
        $occupation->setLabel('Occupation')
            ->setAttribs([
                'class' => 'form-control'
            ]);

        $about = new Zend_Form_Element_Textarea('about');
        $about->setLabel('About')
            ->setAttribs([
                'class' => 'form-control',
                'rows' => 7,
                'cols' => 10
            ]);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setValue('Save Changes')
            ->setAttribs([
                'class' => 'btn btn-info btn-round btn-block pull-right'
            ]);

        $this->addElements([$id, $username, $firstname, $lastname, $phone, $email, $interests, $occupation, $about, $submit]);

    }


}

