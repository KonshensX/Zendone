<?php

class Application_Plugin_Profile extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();

        $view->whatever = 'foo';
    }
}