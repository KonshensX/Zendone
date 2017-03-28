<?php

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

class ProfileController extends Zend_Controller_Action
{

    public function init ()
    {
        /* Initialize action controller here */
    }

    /**
     * Profile settings
     * @throws Zend_Db_Table_Exception
     */
    //TODO: Get the id of the current logged in user
    public function editAction () {
        //TODO: Need the user ID
        $userID = Zend_Auth::getInstance()->getIdentity()->id;
        //Getting the profile from the database
        $profileManager = new Application_Model_DbTable_Profile();
        $postManager = new Application_Model_DbTable_Post();
        $profile = $profileManager->fetchAll($profileManager->select()->where('user_id = ?', $userID));
        $posts = $postManager->fetchAll($postManager->select()->where('user_id = ?', $userID));

        //Profile form
        $form = new Application_Form_Profile();
        //Avatar form 
        $avatarForm = new Application_Form_Avatar();
        $avatarForm->setAction($this->_helper->url('avatar'));
        $form->populate($profile->current()->toArray());
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            //Getting rid of the
            unset($data['submit']);
            if ($form->isValid($data)) {
                //TODO: This is not good, this should be replaced
                $where["user_id = ?"] = $userID;
                $profileManager->update($data, $where);
                $this->_helper->flashMessenger->addMessage(['success' => 'Your profile was successfully updated!']);
            }
        }
        $this->view->assign(array(
            'profileForm' => $form,
            'profileSettings' => $profile->current(),
            'avatarForm' => $avatarForm,
            'posts' => $posts,
            'flashmsgs' => $this->_helper->flashMessenger->getMessages()
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
        $userID = Zend_Auth::getInstance()->getIdentity()->id;
        $profileManager = new Application_Model_DbTable_Profile();
        $profile = $profileManager->fetchAll($profileManager->select()->where('user_id = ?', $userID));

        $this->view->assign([
            'profile' => $profile->current()
        ]);
    }

    /**
     * Handle the upload and cropping of the user avatar
     */
    public function avatarAction () {

        //This is going to handle the upload of the avatar and
        //Do stuff with the image
        //Data gon' come through an ajax request
        if ($this->getRequest()->isXmlHttpRequest()) {
            $x = 0;
            $y = 0;
            $width = 0;
            $height = 0;
            $tmp_file = $_FILES['file-0']['tmp_name'];
            $filename = $_FILES['file-0']['name'];
            if(isset($_POST)) {
                $x = $_POST['x'];
                $y = $_POST['y'];
                $width = $_POST['width'];
                $height = $_POST['height'];
            }
            $imagine = new Imagine();
            $image = $imagine->open($tmp_file);
            $temp = explode('.', $filename);
            $extension = '.' . $temp[count($temp) - 1];
            $filename = md5($filename) . $extension;
            $image
                ->crop(new Point($x, $y), new Box($width, $height))
                ->save(getcwd() . '/../data/uploads/profile/' . $filename);

            //update the avatar in the profile table
            //TODO:
            $userID = Zend_Auth::getInstance()->getIdentity()->id;
            $profileManager = new Application_Model_DbTable_Profile();
            //$profile = $profileManager->fetchAll($profileManager->select()->where('user_id = ?', $userID))->current();
            $where['user_id = ?'] = $userID;
            $data['avatar'] = $filename;
            $profileManager->update([
                'avatar' => $filename
            ], $where);

            //Return some json indicating whether it was  a successful upload or not
            //TODO:
            $this->_helper->json([
                'success' => 'yeah the photo was uploaded'
            ]);
        }
    }


}

