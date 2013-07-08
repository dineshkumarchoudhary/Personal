<?php
// module/Contact/src/Contact/Form/ContactForm.php
namespace Contact\Form;
use Zend\Form\Form;
use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;

class ContactForm extends Form
{
	public function __construct($urlcaptcha = null)
	{
		parent::__construct('contact');		
		$this->setAttribute('method','post');
		
		$this->add(array(
						'name'=>'name', 
						'required' => true,
						'attributes'=>array('type'=>'text',),
						'options'=>array('label'=>'Name',),
						));
						
		$this->add(array(
						'name' => 'email',	
						'required' => true,
						'attributes' => array('type' => 'text',),
						'options' => array('label' => 'Email',),
						));
						
		$this->add(array(
						'name' => 'subject', 
						'required' => true,
						'attributes' => array('type' => 'text',),
						'options' => array('label' => 'Subject',),
						));
						
		$this->add(array(
						'name' => 'message', 
						'attributes' => array('type' => 'textarea',), 
						'options' => array('label' => 'Message',),
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
		
		$this->add(array('name' => 'submit', 'attributes' => array('type' => 'submit', 'value' => 'Submit', 'id' => 'submit'),));
	}
}