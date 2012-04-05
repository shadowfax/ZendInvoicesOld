<?php
class ZendInvoices_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
//tableau associatif reprenant les infos utilis�es pour le lien
	//si l'utilisateur n'est pas authentifi�
	private $_noauth = array(
		'module' => 'default',
		'controller' => 'auth',
		'action' => 'index'
	);
 
	//tableau associatif reprenant les infos utilis�es pour le lien
	//si l'utilisateur est authentifi� mais qu'il n'a pas les droits d'acc�s
	private $_noacl = array(
		'module' => 'default',
		'controller' => 'error',
		'action' => 'deny'
	);
 
	//la m�thode �v�nementielle preDispatch(), d�finie par ZF, est ex�cut�e
	//avant qu'une action ne soit distribu�e
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$acl = null;
		$role = null;
 
		//v�rification de l'enregistrement de l'ACL (cf. application/acls/MyAcl.php)
		if(Zend_Registry::isRegistered('Zend_Acl'))
		{
			//r�cup�ration de l'ACL
			$acl = Zend_Registry::get('Zend_Acl');
		}
		else
		{
			throw new Zend_Controller_Exception("Acl not defined !");
		}
 
		//r�cup�ration de l'instance d'identification
		//la classe Zend_Auth permet de d�finir les adaptateurs d'authentification
		//un adpatateur permet de d�finir le service d'authentification,
		//dans notre cas, une base de donn�es
		$auth = Zend_Auth::getInstance();
 
		//permet de v�rifier si une identit� est correctement identifi�e
		if($auth->hasIdentity())
		{
			//r�cup�ration du role (via la database)
			$role = $auth->getIdentity()->role;
		}
		else
		{
			//si l'utilisateur n'est pas authentifi�
			//on d�finit le r�le par d�faut, guest
			$role = 'guest';
		}
 
		//r�cup�ration du module, contr�leur et action demand�s par la requ�te
		//comme nous avons utilis� les contr�leurs comme ressource,
		//nous stockons le contr�leur demand� dans la requ�te dans la variable $ressource
		$module = $request->getModuleName();
		$controller = $ressource = $request->getControllerName();
		$action = $request->getActionName();
 
		//v�rification que le contr�leur est d�finit dans l'ACL
		if(!$acl->has($controller))
		{
			$ressource = null;
		}
 
		//si l'acc�s n'est pas permis, nous allons modifier la requ�te
		//en modifiant le module, le contr�leur et l'action
		if(!$acl->isAllowed($role, $ressource, $action))
		{
			//si pas authentifi�
			if(!$auth->hasIdentity())
			{
				//$request->setParam('redirect', $module . '/' . $controller . '/' . $action);
				$module = $this->_noauth['module'];
				$controller = $this->_noauth['controller'];
				$action = $this->_noauth['action'];
			}
			else
			{
				//si pas autoris�
				$module = $this->_noacl['module'];
				$controller = $this->_noacl['controller'];
				$action = $this->_noacl['action'];
			}
		}
 
		//d�finition des du module, du contr�leur et de l'action
		//qui sera �aintenant rout�e
		//$request->setModuleName($module);
		$request->setControllerName($controller);
		$request->setActionName($action);
	}
}