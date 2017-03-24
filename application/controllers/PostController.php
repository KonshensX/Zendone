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
        $row = $posts->find(1);
        echo "<pre>";
        var_dump($row->current());
        die();

        $this->view->assign(array(

        ));
    }

    public function addAction() {

        $form = new Application_Form_Post();

        $request = $this->getRequest();

        $post = new Application_Model_DbTable_Post();
        $date = new Zend_Date();
        $data = array(
            'title' => "The title",
            'description' => "test description",
            'category_id' => 1,
            'date' => $date->toString('YYYY-MM-dd HH:mm:ss'),
            'owner' => "konshensx",
            'price' => 112,
            'phone' => '06665654',
            'email' => 'fuck@gmail.com',
            'cover' => 'no-cover.png',
        );

        $post->insert($data);

        $this->view->assign(array(
            'form' => $form
        ));
    }

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

