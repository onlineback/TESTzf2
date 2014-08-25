<?php

/**
 * Description of Module
 *
 * @author  Jared Cusi<jared@likerow.com>, <@likerow>
 */

namespace Omagua;

use Application\View\Helper\MenusHelper;

class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Omagua\Model\TableWpPosts' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new Model\TableWpPosts($dbAdapter);
                    return $table;
                },
                'Omagua\Model\TableWpOptions' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new Model\TableWpOptions($dbAdapter);
                    return $table;
                },
                'Omagua\Model\TableWpPostMeta' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new Model\TableWpPostMeta($dbAdapter);
                    return $table;
                },
            ),
        );
    }

}
