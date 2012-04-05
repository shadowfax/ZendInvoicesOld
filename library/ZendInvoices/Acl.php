<?php
class ZendInvoices_Acl extends Zend_Acl
{
	public function __construct()
	{
		$this->_initResources();
		$this->_initRoles();
		$this->_initRights();
 
		//Zend_Registry permet de gérer une collection de valeurs qui
		//sont peuvent être accessibles n'importe où dans notre application
		//ont peut comparer son fonctionnement à une variable globale
		Zend_Registry::set('Zend_Acl', $this);
	}
	
	protected function _initResources()
	{
		//création des ressources
		//une ressource correspond à un élément pour lequel l'accès est contrôlé
		//ici, nous créons une ressource par contrôleur, ce qui signifie
		//que nous allons contrôler l'accès à nos contrôleurs
		//la méthode addRessource() permet d'ajouter les ressources à l'ACL
		$this->addResource(new Zend_Acl_Resource('index'));
		$this->addResource(new Zend_Acl_Resource('error'));
		$this->addResource(new Zend_Acl_Resource('auth'));
	}
	
	protected function _initRoles()
	{
		//création des rôles
		//un rôle est un objet qui demande l'accès aux ressources
		//nous allons, ici, utiliser 3 rôles:
		//  - guest: compte invité avec des droits limités
		//  - reader: simple accès en lecture
		//  - admin: accès total au site (lecture écriture
		$guest = new Zend_Acl_Role('guest');
		$reader = new Zend_Acl_Role('reader');
		$user = new Zend_Acl_Role('user');
		$admin = new Zend_Acl_Role('administrator');
 
		//ajout des rôles à l'ACL avec la méthode addRole()
		//le premier argument est le rôle à ajouter à l'ACL
		//le second argument permet d'indiquer l'héritage du groupe parent
		//reader va hériter des droits de guest
		//admin va hériter des droits de reader
		$this->addRole($guest);
		$this->addRole($reader, $guest);
		$this->addRole($user, $reader);
		$this->addRole($admin, $user);
	}
	
	protected function _initRights()
	{
		//définition des règles
		//la méthode allow permet d'indiquer les permissions de chaque rôle
		//le premier argument permet de définir le rôl pour qui la régle est écrite
		//le second argument permet d'indiquer les contrôleurs
		//le troisième indique les actions du contrôleur
		//à noter qu'il aussi possible de refuser un accès grâce à la fonction deny()
		$this->allow('guest', array('error', 'auth'));
		$this->allow('reader', 'index');
		$this->allow('user');
		$this->allow('administrator');
	}
	
}