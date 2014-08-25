<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StickyNote
 *
 * @author  Jared Cusi<jared@likerow.com>, <@likerow>
 */

namespace Omagua\Model\Entity;

class WpPosts {

    protected $_ID;
    protected $_post_title;
    protected $_post_content;
    protected $_post_name;
    protected $_post_excerpt;
    protected $_guid;
    protected $_icon;
    protected $_description;
    protected $_title_seo;

    public function __construct(array $options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        $this->$method($value);
    }

    public function __get($name) {
        $method = 'get' . $name;
        if (!method_exists($this, $method)) {
            throw new Exception('Invalid Method');
        }
        return $this->$method();
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function getId() {
        return $this->_ID;
    }

    public function setTitleSeo($id) {
        $this->_title_seo = $id;
        return $this;
    }

    public function getTitleSeo() {
        return $this->_title_seo;
    }

    public function setDescription($id) {
        $this->_description = $id;
        return $this;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function setId($id) {
        $this->_ID = $id;
        return $this;
    }

    public function getTitle() {
        return $this->_post_title;
    }

    public function getName() {
        return $this->_post_name;
    }

    public function getGuid() {
        return $this->_guid;
    }

    public function setTitle($note) {
        $this->_post_title = $note;
        return $this;
    }

    public function setContentCorto($content) {
        $this->_post_excerpt = $content;
        return $this;
    }

    public function setLink($link) {
        $this->_link = $link;
        return $this;
    }

    public function setIcon($content) {
        $this->_icon = $content;
        return $this;
    }

    public function getLink() {
        return $this->_link;
    }

    public function getIcon() {
        return $this->_icon;
    }

    public function getContentCorto() {
        return $this->_post_excerpt;
    }

    public function setName($name) {
        $this->_post_name = $name;
        return $this;
    }

    public function setGuid($name) {
        $this->_guid = $name;
        return $this;
    }

    public function getContent() {
        return $this->_post_content;
    }

    public function setContent($created) {
        $this->_post_content = $created;
        return $this;
    }

}

?>
