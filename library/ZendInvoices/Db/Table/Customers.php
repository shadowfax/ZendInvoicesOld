<?php
class ZendInvoices_Db_Table_Customers extends Zend_Db_Table_Abstract
{
	protected $_name = 'customers';
	protected $_primary = 'id';
	
	public function getCount()
	{
		$select = $this->select();
		$select->from($this->_name, new Zend_Db_Expr("COUNT(id)"));
		return $this->getAdapter()->fetchOne($select);
	}
	
	public function getPaginator()
	{
		$adapter = new Zend_Paginator_Adapter_DbSelect(
			$this->select()
			->order('name')
		);
		
		return new Zend_Paginator($adapter);
	}
	
}