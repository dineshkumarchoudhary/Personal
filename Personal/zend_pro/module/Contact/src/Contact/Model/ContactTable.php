<?php
// module/Contact/src/Contact/Model/ContactTable.php
namespace Contact\Model;

use Zend\Db\TableGateway\TableGateway;

class ContactTable
{
	protected $name;
	protected $email;
	protected $subject;
	protected $message;
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function addContactus($cdata)
	{
		$data = array('name' => $cdata['name'], 
					  'email' => $cdata['email'], 
					  'subject' => $cdata['subject'], 
					  'message' => $cdata['message']
					 );
		$this->tableGateway->insert($data);
	}
}
	

