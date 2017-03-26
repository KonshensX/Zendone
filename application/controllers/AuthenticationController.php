<?php

class AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction () {
        //TODO
        //Check if the user is already logged in
        if (Zend_Auth::getInstance()->hasIdentity()) {
            //Just redirect if he already logged in
            die("YOu are already logged in");
        }
        $form = new Application_Form_Login();
        $request = $this->_request;
        if ($request->isPost()) {
            $username = $request->getParam('username');
            $pwd = $request->getParam('password');
            $authAdapter = $this->getAuthAdapter();

            $authAdapter->setIdentity($username)->setCredential($pwd);

            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($authAdapter);

            if ($result->isValid()) {
                $identity = $authAdapter->getResultRowObject();
                //Store the identity application wide
                $storage = $auth->getStorage();
                $storage->write($identity);

                //Redirect to index after logging in
                $this->getHelper('Redirector')->gotoSimple('index', 'post');
            } else {
                die('wrong stuff');
            }
        }

        $this->view->assign([
            'form' => $form
        ]);
    }

    public function logoutAction () {
        //TODO
        Zend_Auth::getInstance()->clearIdentity();
        //$this->redirect()
    }

    private function getAuthAdapter () {
        //TODO:Get the auth adapter
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
                   ->setIdentityColumn('username')
                   ->setCredentialColumn('password');
        return $authAdapter;
    }


}

