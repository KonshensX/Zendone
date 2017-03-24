<?php

class Application_Model_DbTable_Post extends Zend_Db_Table_Abstract
{

    protected $_name = 'posts';

    protected $_dependentTables = array(Application_Model_DbTable_Category::class);


    protected $_referenceMap = array(
        'Category' => array(
            'columns' => array('id'),
            'refTableClass' => Application_Model_DbTable_Category::class,
            'RefColumns' => array('category_id'),
        ),
    );
}

