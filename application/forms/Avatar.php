<?php

class Application_Form_Avatar extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $file = new Zend_Form_Element_File('avatar');

        $button = new Zend_Form_Element_Submit('submit');
        $button->setAttribs(array(
            'class' => 'btn btn-round btn-info btn-block'
        ));

        $this->addElements(array($file, $button));
    }


}

