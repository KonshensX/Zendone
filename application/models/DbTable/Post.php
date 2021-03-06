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

    /**
     * Gets the full list of items along with their categoryies
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getPostsWithCategory () {
        $query = $this->select();
        $query->from(array('p' => 'posts'))
              //->join(array('c' => 'categories'), 'p.category_id = c.id')
              ->order('p.id DESC');
        $query->setIntegrityCheck(false);

        $result = $this->fetchAll($query);
        return $result;
    }

    /**
     * Get an item along with the post by ID
     * @param $id Integer
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function getPostWithCategory ($id) {
        $query = $this->select();
        $query->from(array('p' => 'posts'))
            ->join(array('c' => 'categories'), 'p.category_id = c.id')
            ->where('p.id = ?', $id);
        $query->setIntegrityCheck(false);

        $result = $this->fetchRow($query);
        return $result;
    }

    /**
     * Get the List of the posts that are not yet approved
     *
     * @return Zend_Db_Select
     */
    public function getPostsNotActiveYet () {
        $query =  $this->select()->from(['p' => 'posts'])->where('active = 0')->order('p.id DESC');

        return $this->fetchAll($query);
    }

    /**
     * Return one page of order entries
     *
     * @param int $page page number
     * @return Zend_Paginator Zend_Paginator
     */
    public function getOnePageOfPosts($page=1) {

        $query = $this->select()->from(array('p' => 'posts'))->where('active = 1')->order('p.id DESC');
        $paginator = new Zend_Paginator(
            new Zend_Paginator_Adapter_DbTableSelect($query)
        );
        $paginator->setItemCountPerPage(4);
        $paginator->setCurrentPageNumber($page);
        return $paginator;
    }
}

