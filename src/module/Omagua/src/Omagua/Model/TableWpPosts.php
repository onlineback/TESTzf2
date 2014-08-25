<?php

/**
 * Description of StickyNotesTable
 *
 * @author  Jared Cusi<jared@likerow.com>, <@likerow>
 */
// module/StickyNotes/src/StickyNotes/Model/StickyNotesTable.php

namespace Omagua\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class TableWpPosts extends AbstractTableGateway {

    protected $table = 'wp_posts';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchAll() {
        $resultSet = $this->select(function (Select $select) {
                    $select->order('created ASC');
                });
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new Entity\StickyNote();
            $entity->setId($row->id)
                    ->setNote($row->note)
                    ->setCreated($row->created);
            $entities[] = $entity;
        }
        return $entities;
    }

    /**
     * Estrae menus de blog
     * @return \Omagua\Model\Entity\WpPosts
     */
    public function getMenus() {
        $resultSet = $this->select(function (Select $select) {
                    $select->group('post_name');
                    $select->where(array('post_type=?' => 'page', 'post_status=?' => 'publish'));
                    $select->where(array("post_name in('home','origen','beneficios','productos','contactenos')"));
                    $select->order('post_type ASC');
                });
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new Entity\WpPosts();
            $entity->setId($row->ID)
                    ->setTitle($row->post_title)
                    ->setName($row->post_name);
            $entities[] = $entity;
        }
        return $entities;
    }

    /**
     * 
     * @return \Omagua\Model\Entity\WpPosts
     */
    public function getOtherPost() {
        $resultSet = $this->select(function (Select $select) {
                    $select->join("wp_postmeta", "wp_posts.ID = wp_postmeta.post_id"
                            , array("*"), "LEFT");
                    $select->join(array('t1' => "wp_posts"), "t1.ID = wp_postmeta.meta_value", array('postid' => 'ID', 'uriimage' => 'guid'), "LEFT");                    
                    $select->where(array("wp_postmeta.meta_key in('_thumbnail_id','title_tag','meta_description')"));
                    $select->where(array('wp_posts.post_type=?' => 'page', 'wp_posts.post_status=?' => 'publish', 'wp_posts.post_name not like ?' => '%producto-omagua%'));
                    $select->where(array("wp_posts.post_name not in('home','origen','beneficios','productos','contactenos')"));
                    $select->order('wp_posts.post_date desc');
                    $select->order('wp_posts.post_type ASC');
                });
        $entities = array();
        foreach ($resultSet as $row) {
            if (empty($entities[$row->ID])) {
                $entity = new Entity\WpPosts();
                $entity->setId($row->ID)
                        ->setName($row->post_name)
                        ->setIcon($row->uriimage)
                        ->setTitle($row->post_title)
                        ->setContent($row->post_content)
                        ->setDescription($row->post_excerpt);
                if ($row->meta_key == 'title_tag') {
                    $entity->setTitleSeo($row->meta_value);
                }
                elseif ($row->meta_key == 'meta_description') {
                    $entity->setContentCorto($row->meta_value);
                }
            }
            else {
                if ($row->meta_key == 'title_tag') {
                    $entity->setTitleSeo($row->meta_value);
                }
                elseif ($row->meta_key == 'meta_description') {
                    $entity->setContentCorto($row->meta_value);
                }
            }
            $entities[$row->ID] = $entity;
        }
        return $entities;
    }

    /**
     * 
     * @return \Omagua\Model\Entity\WpPosts
     */
    public function getOtherProduct() {
        $resultSet = $this->select(function (Select $select) {
                    $select->join("wp_postmeta", "wp_posts.ID = wp_postmeta.post_id"
                            , array("*"), "LEFT");
                    $select->join(array('t1' => "wp_posts"), "t1.ID = wp_postmeta.meta_value", array('postid' => 'ID', 'uriimage' => 'guid', 'post_content'), "LEFT");
                    //$select->group('wp_posts.post_name');
                    $select->where(array("wp_postmeta.meta_key in('_thumbnail_id','title_tag','meta_description')"));
                    $select->where(array('wp_posts.post_type=?' => 'page', 'wp_posts.post_status=?' => 'publish', 'wp_posts.post_name like ?' => '%producto-omagua%'));
                    $select->where(array("wp_posts.post_name not in('home','origen','beneficios','productos','contactenos')"));
                    $select->order('wp_posts.post_date desc');
                    $select->order('wp_posts.post_type ASC');
                    //echo $select->getSqlString();exit;
                });

        $entities = array();
        foreach ($resultSet as $row) {
            if (empty($entities[$row->ID])) {
                $entity = new Entity\WpPosts();
                $entity->setId($row->ID)
                        ->setName($row->post_name)
                        ->setIcon($row->uriimage)
                        ->setContent($row->post_content)
                        ->setTitle($row->post_title)
                        ->setDescription($row->post_excerpt);
                if ($row->meta_key == 'title_tag') {
                    $entity->setTitleSeo($row->meta_value);
                }
                elseif ($row->meta_key == 'meta_description') {
                    $entity->setContentCorto($row->meta_value);
                }
            }
            else {
                if ($row->meta_key == 'title_tag') {
                    $entity->setTitleSeo($row->meta_value);
                }
                elseif ($row->meta_key == 'meta_description') {
                    $entity->setContentCorto($row->meta_value);
                }
            }
            $entities[$row->ID] = $entity;
        }

        return $entities;
    }

    /**
     * 
     * @return \Omagua\Model\Entity\WpPosts
     */
    public function getPost($idPost) {
        $row = $this->select(array('post_name=?' => $idPost))->current();
        if (!$row)
            return false;

        $post = new Entity\WpPosts(array(
                    'Id' => $row->ID,
                    'Title' => $row->post_title,
                    'Name' => $row->post_name,
                    'Content' => $row->post_content,
                ));
        return $post;
    }

    /**
     *  Retorn post por nombre de post
     * @param type $idPost
     * @return boolean|\Omagua\Model\Entity\WpPosts
     */
    public function getPostName($name) {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('wp_posts')
                ->join("wp_postmeta", "wp_posts.ID = wp_postmeta.post_id"
                        , array("*"), "LEFT")
                ->join(array('t1' => "wp_posts"), "t1.ID = wp_postmeta.meta_value", array('postid' => 'ID', 'uriimage' => 'guid'), "LEFT")
                ->group('wp_posts.post_name')
                ->where(array('wp_postmeta.meta_key=?' => '_thumbnail_id'))
                ->where(array('wp_posts.post_type=?' => 'page', 'wp_posts.post_status=?' => 'publish'))
                ->where(array('wp_posts.post_name=?' => $name))
                ->order('wp_posts.post_type ASC')
                ->limit(1);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $post = (object) array();
        foreach ($result as $row) {
            $row = (object) $row;

            $sqls = new Sql($this->adapter);
            $select1 = $sqls->select();
            $select1->from('wp_posts')
                    ->where(array('wp_posts.post_type=?' => 'revision', 'wp_posts.post_status=?' => 'inherit'))
                    ->where(array('wp_posts.post_parent=?' => $row->ID))
                    ->limit(1)
                    ->order('wp_posts.post_type ASC')
                    ->order('wp_posts.post_date desc');
            //echo $select->getSqlString();exit;
            $statement = $sql->prepareStatementForSqlObject($select1);
            $result1 = $statement->execute();
            foreach ($result1 as $row1) {
                $row1 = (object) $row1;
                $post = new Entity\WpPosts(array(
                            'Id' => $row->ID,
                            'Title' => $row1->post_title,
                            'Name' => $row1->post_name,
                            'Content' => $row1->post_content,
                            'Icon' => $row->uriimage,
                            'ContentCorto' => $row1->post_excerpt
                        ));
            }
        }
        return $post;
    }

    public function getSlide() {
        $resultSet = $this->select(function (Select $select) {
                    $select->group('post_name');
                    $select->where(array('post_type=?' => 'attachment'));
                    $select->where(array('post_name like ?' => 'slider%'));
                    $select->order('post_type ASC');
                    //echo $select->getSqlString();exit;
                });
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new Entity\WpPosts();
            $entity->setId($row->ID)
                    ->setTitle($row->post_title)
                    ->setName($row->post_name)
                    ->setGuid($row->guid);
            $entities[] = $entity;
        }
        return $entities;
    }

}