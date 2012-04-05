<?php
class ZendInvoices_Db_Table_Currencies extends Zend_Db_Table_Abstract
{
	protected $_name = 'currencies';
	protected $_primary = 'iso_code';
	
	public function getCurrencyList()
	{
		$select = $this->select();
		$select->from($this->_name, array('iso_code', 'name'))
			->order('name');
		
		return $this->fetchAll($select); 
	}

}