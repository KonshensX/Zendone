<?php

class RegisterController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function registerAction () {
        //TODO: Create the registration form
        
        $registrationForm = new Application_Form_Register();

        $request = $this->getRequest();

        if ($request->isPost() ) {
            //If the user already exists redirect to the login page
            $username  = $request->getParam('username');
            $email  = $request->getParam('email');
            $password  = $request->getParam('password');
            $confirmPassword= $request->getParam('confirmPassword');

            //If the passwords does not match don't do anything .
            if (!($password === $confirmPassword)) {
                die("Passwords does not match ");
            }
            
            $userManager = new Application_Model_DbTable_User();
            //Creating the hash of the password
            $user['username'] = $username;
            $user['email'] = $email;
            $user['password'] = md5($password);
            $userID = $userManager->insert($user);

            //TODO: Create a profile when a user is created .
            $profileManager = new Application_Model_DbTable_Profile();
            $profile['username'] = $username;
            $profile['user_id'] = $userID;
            $profileManager->insert($profile);
            //Log the user in then redirect to the profile
            $this->logUserIn($username, $password);

            //Redirect the profile settings after the user is registered
            $this->getHelper('Redirector')->goToUrl('/profile/edit');
        }

        $this->view->assign([
            'register' => $registrationForm
        ]);
    }

    public function UserAlreadyRegistered ($username = null, $email = null) {
        //TODO: check if the user already exists
    }

    /**
     * Log the user in
     * @param null $username
     * @param null $password
     */
    private function logUserIn ($username = null, $password = null)  {
        $authAdapter = $this->getAuthAdapter();

        $authAdapter->setIdentity($username)->setCredential($password);

        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()) {
            $identity = $authAdapter->getResultRowObject();
            //Store the identity application wide
            $storage = $auth->getStorage();
            $storage->write($identity);
        } else {
            die('Something wrong happened');
        }
    }

    private function getAuthAdapter () {
        //TODO:Get the auth adapter
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
            ->setIdentityColumn('username')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('MD5(?)');
        return $authAdapter;
    }

}

