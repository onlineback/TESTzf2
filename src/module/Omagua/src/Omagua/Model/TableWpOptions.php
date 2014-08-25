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

class TableWpOptions extends AbstractTableGateway {

    protected $table = 'wp_options';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function getOptionName($name) {
        $row = $this->select(array('option_name=?' => $name))->current();        
        if (!$row)
            return false;
        return $row;
    }

}