<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function __construct($application)
    {
        parent::__construct($application);
        Zend_Controller_Front::getInstance()->registerPlugin(new Application_Plugin_Profile());
    }

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initDatabase(){
        // get config from config/application.ini
        $config = $this->getOptions();

        $db = Zend_Db::factory($config['resources']['db']['adapter'], $config['resources']['db']['params']);

        //set default adapter
        Zend_Db_Table::setDefaultAdapter($db);

        //save Db in registry for later use
        Zend_Registry::set("db", $db);
    }

    protected function _initRoutes()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        include APPLICATION_PATH . "/configs/routes.php";
    }

    protected function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layout = $this->_bootstrap()->getResource('Layout');
        $view = $layout->getView();

        $view->assign([
            'foo' => 'foo'
        ]);
    }

}

