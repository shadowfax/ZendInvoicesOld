<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	protected function _initAcl()
	{
		//Création d'une instance de notre ACL
		$acl = new ZendInvoices_Acl();
	 
		//enregistrement du plugin de manière à ce qu'il soit exécuté
		Zend_Controller_Front::getInstance()->registerPlugin(new ZendInvoices_Controller_Plugin_Acl());
	 
		//permet de définir l'acl par défaut à l'aide de vue, de cette manière
		//l'ACL est accessible dans les vues
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
	 
		//vérifie si une identité existe et applique le rôle
		$auth = Zend_Auth::getInstance();
		$role = (!$auth->hasIdentity()) ? 'guest' : $auth->getIdentity()->role;
	}
	

}

