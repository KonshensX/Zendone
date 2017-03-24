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
            $data['date'] = $date->toString('YYYY-mm-dd HH:mm:ss');
            $data['owner'] = "owner comming from the auth stuff";

            unset($data['submit']);
            $post->insert($data);
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


}

