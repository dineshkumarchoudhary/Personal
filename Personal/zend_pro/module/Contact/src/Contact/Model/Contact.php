<?php
// module/Contact/src/Contact/Model/Contact.php
namespace Contact\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Contact implements InputFilterAwareInterface
{
	public $name;
	public $email;
	public $subject;
	public $message;
	protected $inputFilter;
	
	public function exchangeArray($data)
	{
		$this->name = (isset($data['name']))?$data['name']:null;
		$this->email = (isset($data['email']))?$data['email']:null;
		$this->subject = (isset($data['subject']))?$data['subject']:null;
		$this->message = (isset($data['message']))?$data['message']:null;
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('Not Used');
	}
	
	public function getInputFilter()
	{
		if(!$this->inputFilter)
		{
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			$inputFilter->add($factory->createInput(array(
							'name' => 'name',
							'required' => true,
							'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
							),
							'validators' => array(
								array(
									'name' => 'StringLength',
									'options' => array(
										'encoding' => 'UTF-8',
										'min' => 1,
										'max' => 255,
									),
								),
							),
			)));
			$inputFilter->add($factory->createInput(array(
							'name' => 'email',
							'required' => true,
							'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
							),
							'validators' => array(
								array(
									'name' => 'StringLength',
									'options' => array(
										'encoding' => 'UTF-8',
										'min' => 1,
										'max' => 255,
									),
								),
							),
			)));
			$inputFilter->add($factory->createInput(array(
							'name' => 'subject',
							'required' => true,
							'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
							),
							'validators' => array(
								array(
									'name' => 'StringLength',
									'options' => array(
										'encoding' => 'UTF-8',
										'min' => 1,
										'max' => 800,
									),
								),
							),
			)));
			$inputFilter->add($factory->createInput(array(
							'name' => 'message',
							'required' => true,
							'filters' => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
							),
							'validators' => array(
								array(
									'name' => 'StringLength',
									'options' => array(
										'encoding' => 'UTF-8',
										'min' => 1,
										'max' => 800,
									),
								),
							),
			)));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}