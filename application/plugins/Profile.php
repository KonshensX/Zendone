<?php

class Application_Plugin_Profile extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        //I need to pass these values to the if the user is logged in
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();
            $searchForm = new Application_Form_Search();
            $userID = Zend_Auth::getInstance()->getIdentity()->id;
            $profileManager = new Application_Model_DbTable_Profile();
            $profile = $profileManager->find($userID);
            $view->assign([
                'searchForm' => $searchForm,
                'profile' => $profile->current(),
            ]);
            return;
        }
    }
}