<?php

class PostController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // Display all the items in the database along with the pagination and stuff

        $posts = new Application_Model_DbTable_Post();
        $rows = $posts->getPostsWithCategory();



        $this->view->assign(array(
            'paginator' => $rows
        ));
    }

    public function displayAction () {
        $id = (int)$this->_request->getParam('id', 2);

        if (!$id) {
            //Redirect if no id
            //$this->redirect();
        }

        $postManager = new Application_Model_DbTable_Post();
        $post = $postManager->getPostWithCategory(1);

        $this->view->assign([
            'post' => $post->current()
        ]);
    }

    /**
    * Add a new item
    **/
    public function addAction() {

        $form = new Application_Form_Post();

        $request = $this->getRequest();

        $post = new Application_Model_DbTable_Post();
        $date = new Zend_Date();
        if ($request->isPost()) {
            $data = $request->getPost();
            $data['date'] = $date->toString('YYYY-MM-dd HH:mm:ss');
            $data['owner'] = "owner comming from the auth stuff";

            unset($data['submit']);
            $id = $post->insert($data);
            //This redirects to the cover url along with the id
            $this->getHelper('Redirector')->gotoSimple('cover', 'post', null, ['id' => $id]);
        }


        $this->view->assign(array(
            'form' => $form
        ));
    }

    /**
     * Upload the cover of the item
     */
    public function uploadAction() {
        $form = new Application_Form_Cover();
        $adapter = new Zend_File_Transfer_Adapter_Http();
        $adapter->receive();
        $request = $this->getRequest();


        if ($request->isPost()) {
            //$files = $adapter->getFilesInfo();
            echo "<pre>";
            var_dump($adapter);
            die();
        }
        $this->view->assign(array(
            'form' => $form
        ));
    }

    /**
     * Update the item
     * @throws Zend_Db_Table_Exception
     * @throws Zend_Form_Exception
     */
    public function editAction () {
        //Getting the id of the post from the url => if null default to 1
        $id = (int) $this->getParam('id', 1);
        //Getting the item from the database
        $postManager = new Application_Model_DbTable_Post();
        $post = $postManager->find($id);

        $form = new Application_Form_Post();
        $form->populate($post->current()->toArray());

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            unset($data['submit']);
            if ($form->isValid($data)) {
                $postManager->update($data, 'id = 1');
            }
        }

        $this->view->assign([
            'form' => $form
        ]);
    }


    /**
     * Updates the cover of the post
     */
    public function coverAction () {
        $form = new Application_Form_Cover();

        if ($this->_request->isPost()) {



        }

        $this->view->assign([
            'form' => $form
        ]);
    }


}

