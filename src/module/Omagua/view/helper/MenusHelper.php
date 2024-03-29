<?php
namespace Omagua\View\Helper;
 
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class MenusHelper extends AbstractHelper
{
    protected $request;
 
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
 
    public function __invoke()
    {
        return $this->request->getUri()->normalize();
    }
}