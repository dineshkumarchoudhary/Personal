<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
// session container class
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
		$user_session = new Container('user');
		$username = $user_session->username; 
		
        return new ViewModel(array('username' => $username,));
    }
}
