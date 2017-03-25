<?php

class Application_Form_Cover extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttribs([
            'id' => 'upload-form'
        ]);
        $file = new Zend_Form_Element_File('cover');
        $file->setAttrib('id', 'image-input');
        $file->setAttrib('onChange', 'previewImage()');

        $button = new Zend_Form_Element_Submit('submit');
        $button->setAttribs(array(
            'class' => 'btn btn-round btn-info btn-block'
        ));

        $this->addElements(array($file, $button));
    }


}

