<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //TODO: get all the posts from the database.
        //Get only the posts that are not confirmed yet.
        $post = new Application_Model_DbTable_Post();
        
        $this->view->assign([
           'posts' => $post->getPostsNotActiveYet(),
        ]);
    }

    public function approveAction () {

        //TODO: Set the active field in the database to 1
        $request = $this->getRequest();
        $id = $request->getParam('id');
        //Get the post manager
        $postManager = new Application_Model_DbTable_Post();
        $where['id = ?'] = $id;
        $postManager->update([
            'active' => 1,
        ], $where);


        $this->_helper->redirector('');

    }


}

