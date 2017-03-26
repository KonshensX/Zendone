<?php


use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

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
        $id = (int)$this->getParam('id', 0);

        if (!$id) {
            //Redirect if no id
            //$this->redirect();
            $this->_helper->redirect()->goToUrl('post/index');
        }

        $postManager = new Application_Model_DbTable_Post();

        $post = $postManager->getPostWithCategory($id);
        $this->view->assign([
            'post' => $post
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
            $data['user_id'] = Zend_Auth::getInstance()->getIdentity()->id;

            unset($data['submit']);
            $id = $post->insert($data);
            //This redirects to the cover url along with the id
            $this->getHelper('Redirector')->gotoSimple('cover', 'post', null, [$id]);
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
        //this will need the id of the item whose cover need to be changed
        //TODO: Get id from the url

        $id = (int) $this->_request->getParam('id', 0);
        if (!$id) {
            //die("damn son no id was provided");
            //$this->getHelper('redirector')->go
            $this->_helper->redirector->goToUrl('post/index');
        }


        $form = new Application_Form_Cover();
        $postManager = new Application_Model_DbTable_Post();

        if ($this->_request->isPost()) {
            echo "<pre>";
            var_dump($_FILES);
            //die();
            //Do stuff with the image
            //Data gon' come through an ajax request
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
                ->save(getcwd() . '/../data/uploads/covers/' . $filename);

            //Update the post in the database
            $post = $postManager->find($id)->current();

            $where = $postManager->getAdapter()->quoteInto('id = ?', $id);

            $postManager->update([
                'cover' => $filename,
            ], $where);

            $this->_helper->json([
                'message' => 'success'
            ]);
        }

        $this->view->assign([
            'form' => $form
        ]);
    }


    public function redtAction () {
        $params = array('id' => 20);
        $this->_helper->redirector('cover', 'post', null, $params);
    }

    public function searchAction () {
        $request = $this->getRequest();
        $postManager = new Application_Model_DbTable_Post();

        $where['title like ?'] = '%'.$request->getPost('search').'%';
        $posts = $postManager->fetchAll($where);

        $this->view->assign([
            'title' => $request->getPost('search'),
            'posts' => $posts
        ]);
    }


}

