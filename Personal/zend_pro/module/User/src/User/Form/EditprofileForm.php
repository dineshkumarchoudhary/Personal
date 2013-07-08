<?php
// module/Album/src/Album/Form/EditprofileForm.php:
namespace User\Form;
use Zend\Form\Form;
use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;
class EditprofileForm extends Form
{
	public function __construct()
	{
		// we want to ignore the name passed
		parent::__construct('user');
		$this->setAttribute('method', 'post');		
	  
		$this->add(array(
			'name' => 'id',
			'attributes' => array('type' => 'hidden',),
		));
		$this->add(array(
			'name' => 'username',
			'attributes' => array('type' => 'text','readonly' => 'true',),
			'options' => array('label' => 'Username',),
			
		));
		$this->add(array(
			'name' => 'newpassword',
			'attributes' => array('type' => 'password',),
			'options' => array(
			'label' => 'New Password',
			),
		));
		$this->add(array(
			'name' => 'name',
			'attributes' => array('type' => 'text',),
			'options' => array(
			'label' => 'Name',
			),
		));
		$this->add(array(
			'name' => 'email',
			'attributes' => array('type' => 'text',),
			'options' => array(
			'label' => 'Email',
			),
		));
		
 
		$this->add(array(
			'name' => 'submit',
			'attributes' => array('type' => 'submit','value' => 'Edit profile','id' => 'submitbutton',),
		));
	}
}