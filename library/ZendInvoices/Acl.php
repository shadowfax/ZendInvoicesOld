<?php
class ZendInvoices_Acl extends Zend_Acl
{
	public function __construct()
	{
		$this->_initResources();
		$this->_initRoles();
		$this->_initPermissions();
 
		// We add the ACL to the Zend_Registry which allows us to use
		// this variable across the whole application as if it was 
		// defined globally
		Zend_Registry::set('Zend_Acl', $this);
	}
	
	/**
	 * Initialize ACL resources
	 */
	protected function _initResources()
	{
		$this->addResource(new Zend_Acl_Resource('index'));
		$this->addResource(new Zend_Acl_Resource('error'));
		$this->addResource(new Zend_Acl_Resource('auth'));
	}
	
	/**
	 * Initialize ACL roles
	 */
	protected function _initRoles()
	{
		$guest = new Zend_Acl_Role('guest');
		$reader = new Zend_Acl_Role('reader');
		$user = new Zend_Acl_Role('user');
		$admin = new Zend_Acl_Role('administrator');
 
		// bind the roles to the ACL using the method addRole()
		// The first argument defines the role
		// The second argument defines heritage; that is the role will inherit permission from another role
		$this->addRole($guest);
		$this->addRole($reader, $guest);
		$this->addRole($user, $reader);
		$this->addRole($admin, $user);
	}
	
	/**
	 * Initialize ACL permissions
	 */
	protected function _initPermissions()
	{
		// The allow method allows to set the permissions for each role.
		// The first argument defines the role.
		// The second argument defines de controller
		// The third argument (Optional) defines the action
		// NOTE: We could also use deny() in the same way to explictly deny access.
		$this->allow('guest', array('error', 'auth'));
		$this->allow('reader', 'index');
		$this->allow('user');
		$this->allow('administrator');
	}
	
}