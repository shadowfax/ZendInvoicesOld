<?php
class ZendInvoices_Db_Table_Companies extends Zend_Db_Table_Abstract
{
	protected $_name = 'companies';
	protected $_primary = 'id';
	
	public function findById($id)
	{
		$select = $this->select();
		$select->where('id = ?', $id);
		
		return $this->getAdapter()->fetchRow($select);
	}
	
	
	public function update($data, $id)
	{
		if (!is_numeric($id)) {
			throw new Zend_Db_Exception('Invalid company id');
		} elseif ($id <= 0) {
			throw new Zend_Db_Exception('Invalid company id');
		}
		
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		return parent::update($data, $where);
	}
	
	public function lastInsertedId()
	{
		return $this->getAdapter()->lastInsertId($this->_name);
	}
}