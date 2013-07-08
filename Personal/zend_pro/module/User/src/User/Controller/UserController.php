<?php
// module/User/src/User/Controller/UserController.php:
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Storage;
use User\Model\User;
use User\Model\UserTable;
use User\Form\RegisterForm;
use User\Form\EditprofileForm;
use User\Form\LoginForm;
use Zend\Barcode\Barcode;
use Zend\Session\Container;

class UserController extends AbstractActionController
{
    protected $storage;
    protected $authservice;
	protected $userTable;
	
	public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
         
        return $this->authservice;
    }
    
	public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()->get('User\Model\UserStorage');
        }
         
        return $this->storage;
    }
	
	public function indexAction()
	{	
		if($this->getAuthService()->hasIdentity())
		{
			$username = $this->getAuthService()->getStorage()->read('username');
			$userinfo = $this->getUserTable()->getUserByUsername($username);
			
			/*// Only the text to draw is required
			$barcodeOptions = array('text' => 'ZEND-FRAMEWORK');			
			// No required options
			$rendererOptions = array();			
			// Draw the barcode in a new image,
			// send the headers and the image
			Barcode::factory('code39', 'image', $barcodeOptions, $rendererOptions)->render();*/

			return new ViewModel(array('username' => $username, 'name' => $userinfo->name, 'email' => $userinfo->email, 'profileimg' => $userinfo->profileimg));
		}
		else
			$this->redirect()->toRoute('user', array('controller'=>'user','action'=>'login'));
	}
	
	public function loginAction()
	{
		if($this->getAuthService()->hasIdentity())
			$this->redirect()->toRoute('user', array('controller'=>'user','action'=>'index'));
		
		if($this->getRequest()->isPost())
		{
			$formPost = $this->getRequest()->getPost();
			
			$this->getAuthService()->getAdapter()->setIdentity($formPost['username'])->setCredential($formPost['password']);
            $result = $this->getAuthService()->authenticate();
			
			if($result->isValid())
			{
				if($formPost['rememberme'] == 1)
				{
					$this->getSessionStorage()->setRememberMe(1);
					$this->getAuthService()->setStorage($this->getSessionStorage());
				}
				$this->getAuthService()->getStorage()->write($formPost['username']);
				
				// setting session
				$user_session = new Container('user');
				$user_session->username = $formPost['username'];			
				
				$this->redirect()->toRoute('user', array('controller' => 'user','action' =>  'index'));
			}
			else
			{
				$this->redirect()->toRoute('user', array('controller' => 'user','action' => 'login'));
			}
		}
		$form = new LoginForm();
		return new ViewModel(array('form' => $form,));
	}
	
	public function logoutAction()
	{
		if($this->getAuthService()->hasIdentity())
		{
			$this->getAuthService()->clearIdentity();
			$user_session = new Container('user');
            $user_session->getManager()->destroy(); 
			$this->flashmessenger()->addMessage("You've been logged out");
			$this->redirect()->toRoute('user', array('controller'=>'user','action'=>'login'));
		}
	}
	
	public function registerAction()
	{		
		$form = new RegisterForm($this->getRequest()->getBaseUrl());
		if($this->getRequest()->isPost())
		{
			$formPost = $this->getRequest()->getPost();
			$form->setData($formPost);
			if($form->isValid())
			{
				$this->getUserTable()->saveUser($formPost);
			}
			$this->redirect()->toRoute('user', array('controller'=>'user','action'=>'login'));
		}
		
		return new ViewModel(array('form' => $form,));
	}
	
	public function editprofileAction()
	{
		if($this->getAuthService()->hasIdentity())
		{
			$username = $this->getAuthService()->getStorage()->read('username');
			$userinfo = $this->getUserTable()->getUserByUsername($username);
			$userinfoar = array();
			$userinfoar['username'] = $userinfo->username;
			$userinfoar['name'] = $userinfo->name;
			$userinfoar['email'] = $userinfo->email;
			
			$form = new EditprofileForm();
			$user = new User();
			$user->exchangeArray($userinfoar);
			$form->setInputFilter($user->getInputFilter());
			$form->bind($userinfo);

			if($this->getRequest()->isPost())
			{
				$formData = $this->getRequest()->getPost();
				$formData['password'] = $formData['newpassword'];
				$this->getUserTable()->saveUser($formData);
				$this->redirect()->toRoute('user',array('controller'=>'user','action'=>'index'));
			}
			
			return new ViewModel(array('form' => $form,));
		}
	}
	
	public function avatarAction()
	{
		if($this->getRequest()->isPost())
		{
			$files = $this->params()->fromfiles('fileupload');
			$adapter = new \Zend\File\Transfer\Adapter\Http();
			$adapter->setDestination('public/uploads/');
			echo $files['name'];
			if($adapter->receive($files['name']))
			{
				$username = $this->getAuthService()->getStorage()->read('username');
				$userinfo = $this->getUserTable()->getUserByUsername($username);
				$imgpath = 'uploads/'.$files['name'];
				$this->getUserTable()->updateImgUser($userinfo->id, $imgpath);
				echo 'Success';
				$this->redirect()->toRoute('user', array('controller'=>'user','action'=>'index'));
			}
			else
			{
				echo 'Not Success';
			}
		}
	}
	
	public function getUserTable()
	{
		if (!$this->userTable) {
		$sm = $this->getServiceLocator();
		$this->userTable = $sm->get('User\Model\UserTable');
		}
		return $this->userTable;
	}
}