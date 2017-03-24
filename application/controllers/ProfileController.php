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

    /**
     * Edit the item
     * @throws Zend_Db_Table_Exception
     */
    //TODO: Get the id of the current logged in user
    public function editAction () {
        //Getting the profile from the database
        $profileManager = new Application_Model_DbTable_Profile();
        $profile = $profileManager->find(1);

        $form = new Application_Form_Profile();
        $form->populate($profile->current()->toArray());
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            //Getting rid of the 
            unset($data['submit']);
            if ($form->isValid($data)) {
                //TODO: This is not good, this should be replaced
                $profileManager->update($data, 'id = 1');
            }
        }
        $this->view->assign(array(
            'profileForm' => $form,
            'profile' => $profile
        ));
    }

    /**
     * Display the current user profile
     * @throws Zend_Db_Table_Exception
     */
    //TODO: Get the id of the current logged in user
    public function displayAction () {
        //I need the current user id
        //The user id could be retrieved from the auth stuff

        $profileManager = new Application_Model_DbTable_Profile();
        $profile = $profileManager->find(1);

        $this->view->assign([
            'profile' => $profile->current()
        ]);
    }


}

