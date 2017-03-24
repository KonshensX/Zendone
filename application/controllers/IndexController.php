<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form = new Application_Form_Post();
        $request = $this->getRequest();
        if ($request->isPost()) {



        }

        $this->view->assign(array(
            'form' => $form,
            'data' => "this is some data"
        ));
    }

    public function storeAction() {
        var_dump($this->getRequest());
        die();
    }


}

