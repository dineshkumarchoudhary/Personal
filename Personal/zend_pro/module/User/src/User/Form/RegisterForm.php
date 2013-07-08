<?php
// module/Album/src/Album/Form/RegisterForm.php:
namespace User\Form;
use Zend\Form\Form;
use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;
class RegisterForm extends Form
{
	protected $captcha;
	public function __construct($urlcaptcha = null)
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
			'attributes' => array('type' => 'text',),
			'options' => array('label' => 'Username',),
		));
		$this->add(array(
			'name' => 'password',
			'attributes' => array('type' => 'password',),
			'options' => array(
			'label' => 'Password',
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
		$dirdata = './public';
 
        //pass captcha image options
        $captchaImage = new CaptchaImage(  array(
                'font' => $dirdata . '/fonts/arial.ttf',
                'width' => 250,
                'height' => 100,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3)
        );
        $captchaImage->setImgDir($dirdata.'/captcha');
        $captchaImage->setImgUrl($urlcaptcha.'/captcha');
 
        //add captcha element...
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => $captchaImage,
            ),
        ));
		
		$this->add(array(
			'name' => 'submit',
			'attributes' => array('type' => 'submit','value' => 'Register','id' => 'submitbutton',),
		));
	}
}