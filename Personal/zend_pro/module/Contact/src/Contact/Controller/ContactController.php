<?php
// module/Contact/src/Contact/Controller/ContactController.php

namespace Contact\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Contact\Form\ContactForm;
class ContactController extends AbstractActionController
{
	protected $contactTable;
	
	public function indexAction()
	{
		$form = new ContactForm($this->getRequest()->getBaseUrl());
		return new ViewModel(array('form' => $form));
	}
	
	public function contactAction()
	{
		if($this->getRequest()->isPost())
		{
			$formData = $this->getRequest()->getPost();
			$this->getContactTable()->addContactus($formData);			
		}
		$this->redirect()->toRoute('contact', array('controller'=>'contact', 'action'=>'index'));
	}
	
	public function getContactTable()
	{
		if(!$this->contactTable)
		{
			$sm = $this->getServiceLocator();
			$this->contactTable = $sm->get('Contact\Model\ContactTable');
		}		
		return $this->contactTable;
	}
}