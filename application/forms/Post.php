<?php

class Application_Form_Post extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

        $this->setAction('store');

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Post title')
                ->setAttribs(array(
                    'class' => 'form-control'
                ));

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description')
                    ->setAttribs(array(
                        'class' => 'form-control',
                        'rows' => 5,
                        'cols' => 10
                    ));

        $price = new Zend_Form_Element_Text('price');
        $price->setLabel('Price')
                ->setAttribs(array(
                'class' => 'form-control'
            ));

        $phone = new Zend_Form_Element_Text('phone');
        $phone->setLabel('Phone')
            ->setAttribs(array(
                'class' => 'form-control'
            ));

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
            ->setAttribs(array(
                'class' => 'form-control'
            ));

        $category = new Zend_Form_Element_Select('category');
        $category->setLabel('Category')
            ->setAttribs(array(
                'class' => 'form-control'
            ));
        $category->addMultiOptions(array(
            '1' => 'Technology',
            '2' => 'What the hell is this'
        ));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('submit')
            ->setAttribs(array(
                'class' => 'btn btn-round btn-info pull-right'
            ));

        $this->addElements(array($title, $price, $phone, $email, $category, $description, $submit));

    }


}

