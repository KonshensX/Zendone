<?php


class Application_Form_Search extends Zend_Form{

    public function init()
    {


        $this->setAttribs([
            'style' => 'margin-top: 8px !important;',
            'class' => 'navbar-form'
        ]);

        $search = new Zend_Form_Element_Text('search');
        //$this->setAction()

        $search->setAttribs([
            'class' => 'form-control',
            'placeholder' => 'Search...'
        ]);
        //$this->setAction($this->url(['controller' => 'post', 'action' => 'search']));
        
        $this->addElements([$search]);
    }
}