<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	protected function _initAcl()
	{
		//Cr�ation d'une instance de notre ACL
		$acl = new ZendInvoices_Acl();
	 
		//enregistrement du plugin de mani�re � ce qu'il soit ex�cut�
		Zend_Controller_Front::getInstance()->registerPlugin(new ZendInvoices_Controller_Plugin_Acl());
	 
		//permet de d�finir l'acl par d�faut � l'aide de vue, de cette mani�re
		//l'ACL est accessible dans les vues
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
	 
		//v�rifie si une identit� existe et applique le r�le
		$auth = Zend_Auth::getInstance();
		$role = (!$auth->hasIdentity()) ? 'guest' : $auth->getIdentity()->role;
	}
	

	protected function _initDoctype()
    {
		$this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
   		$view->headMeta()->appendHttpEquiv('Content-Type','text/html; charset=UTF-8');
   		$view->setEncoding('UTF-8');
    }
    
	// ToDo: http://blog.jebrini.net/post/1431025228/url-routing-in-zend-framework-for-dummies
}

