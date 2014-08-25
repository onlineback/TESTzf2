<?php

/**
 * Description of StickyNotesController
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
// module/StickyNotes/src/StickyNotes/Controller/StickyNotesController.php:

namespace Omagua\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

class IndexController extends AbstractActionController {

    public function __construct() {
        
    }

    public function homeAction() {
        $params = $this->params()->fromRoute();        
        $this->layout()->actionc = $params['action'];
        $service = $this->getServiceLocator();
        $tableModel = $service->get('Omagua\Model\TableWpPosts');
        $optionsModel = $service->get('Omagua\Model\TableWpOptions');
        $this->layout()->menus = $tableModel->getMenus();
        $dataSlider = unserialize($optionsModel->getOptionName('easingsliderlite_slideshow')->option_value);
        return new ViewModel(array(
                    'slide' => $dataSlider->slides,
                    'postpages' => $tableModel->getOtherPost(),
                ));
        //$plugin = $this->Load();
    }

    public function origenAction() {
        $params = $this->params()->fromRoute();
        $this->layout()->actionc = $params['action'];
        $service = $this->getServiceLocator();
        $tableModel = $service->get('Omagua\Model\TableWpPosts');
        $this->layout()->menus = $tableModel->getMenus();
        return new ViewModel(array(
                    'post' => $tableModel->getPostName($params['action']),
                ));
    }

    public function postAction() {
        $params = $this->params()->fromRoute();
        $this->layout()->actionc = $params['action'];
        $service = $this->getServiceLocator();
        $tableModel = $service->get('Omagua\Model\TableWpPosts');
        $this->layout()->menus = $tableModel->getMenus();
        return new ViewModel(array(
                    'post' => $tableModel->getPostName($params['namepost']),
                    'postpages' => $tableModel->getOtherPost(),
                ));
    }

    public function productosAction() {
        $this->redirect()->toUrl('/producto/producto-omagua');
        /*$params = $this->params()->fromRoute();
        $this->layout()->actionc = $params['action'];
        $service = $this->getServiceLocator();
        $tableModel = $service->get('Omagua\Model\TableWpPosts');
        $this->layout()->menus = $tableModel->getMenus();
        return new ViewModel(array(
                    'post' => $tableModel->getPost($params['action']),
                    'postpages' => $tableModel->getOtherProduct(),
                ));*/
    }
    
    public function productoAction() {
        $params = $this->params()->fromRoute();        
        $this->layout()->actionc = $params['action'];
        $service = $this->getServiceLocator();
        $tableModel = $service->get('Omagua\Model\TableWpPosts');
        $this->layout()->menus = $tableModel->getMenus();
        return new ViewModel(array(
                    'post' => $tableModel->getPostName($params['namepost']),
                    'postpages' => $tableModel->getOtherProduct(),
                ));
    }

    public function beneficiosAction() {
        $params = $this->params()->fromRoute();
        $this->layout()->actionc = $params['action'];
        $service = $this->getServiceLocator();
        $tableModel = $service->get('Omagua\Model\TableWpPosts');
        $this->layout()->menus = $tableModel->getMenus();
        return new ViewModel(array(
                    'post' => $tableModel->getPost($params['action']),
                ));
    }

    public function contactenosAction() {
        $params = $this->params()->fromRoute();
        $this->layout()->actionc = $params['action'];
        $service = $this->getServiceLocator();
        $tableModel = $service->get('Omagua\Model\TableWpPosts');
        $this->layout()->menus = $tableModel->getMenus();
        $mensaje = array();
        if ($this->params()->fromPost()) {
            $data = $this->params()->fromPost();
            //$validator = new Zend\Validator\EmailAddress();


            if (empty($data['name'])) {
                $mensaje['Nonmbres'] = 'Ingrese Nombres';
            }
            if (empty($data['mail'])) {
                $mensaje['Email'] = 'Ingrese un email valido';
            }

            if (empty($mensaje)) {
                $options = new Mail\Transport\SmtpOptions(array(
                            'name' => 'localhost',
                            'host' => 'smtp.gmail.com',
                            'port' => 587,
                            'connection_class' => 'login',
                            'connection_config' => array(
                                'username' => 'likerow.com@gmail.com',
                                'password' => 'jeraldine',
                                'ssl' => 'tls',
                            ),
                        ));

                $this->renderer = $this->getServiceLocator()->get('ViewRenderer');
                $content = $this->renderer->render('layout/email.phtml', $data);

                $html = new MimePart($content);
                $html->type = "text/html";
                $body = new MimeMessage();
                $body->setParts(array($html,));

                $mail = new Mail\Message();
                $mail->setBody($body); // will generate our code html from template.phtml  
                $mail->setFrom('contactos@cafeomagua.com', 'CafeOmagua.com');
                $mail->setTo('cafeomagua.com@gmail.com');
                $mail->addCc("jccf20@hotmail.com");
                $mail->addCc("enrique.tapia@kstorage.net");
                $mail->addCc("obedcusi@gmail.com");
                $mail->addCc("likerow@gmail.com");
                $mail->setSubject('Contactos | CafeOmagua.com');

                $transport = new Mail\Transport\Smtp($options);
                $transport->send($mail);
                $this->flashMessenger()->addMessage('En hora buena su mensaje se envio corrcetamente en breve nos contactaremos con usted.');
                $this->redirect()->toUrl('/contactenos');
            }
        }
        return new ViewModel(array(
                    'mensajes' => $mensaje,
                    'info' => $this->flashMessenger()->getMessages()));
    }

}