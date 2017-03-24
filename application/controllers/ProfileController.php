<?php

class ProfileController extends Zend_Controller_Action
{

    public function init ()
    {
        /* Initialize action controller here */
    }

    public function indexAction ()
    {
        
    }

    public function editAction () {
        //Getting the profile from the database
        $profileManager = new Application_Model_DbTable_Profile();
        $profile = $profileManager->find(1);

        $form = new Application_Form_Profile();

        if ($this->_request->isPost()) {
            
        }
        $this->view->assign(array(
            'form' => $form,
            'profile' => $profile
        ));
    }


}

