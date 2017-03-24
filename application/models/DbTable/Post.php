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

    public function getPostsWithCategory() {
        $query = $this->select();
        $query->from(array('p' => 'posts'))
              ->join(array('c' => 'categories'), 'p.category_id = c.id')
              ->order('p.id DESC');
        $query->setIntegrityCheck(false);

        $result = $this->fetchAll($query);
        return $result;
    }
}

