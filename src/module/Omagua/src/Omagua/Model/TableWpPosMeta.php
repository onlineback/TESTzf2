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

class TableWpPostMeta extends AbstractTableGateway {

    protected $table = 'wp_postmeta';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }
    /**
     * 
     * @return \Omagua\Model\Entity\WpPosts
     */
    public function getMeta($idPost, $tag) {
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
}