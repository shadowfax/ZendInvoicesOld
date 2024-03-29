<?php
class ZendInvoices_Db_Table_Countries extends Zend_Db_Table_Abstract
{
	protected $_name = 'countries';
	protected $_primary = 'iso1_code';
	
	public function getCountryList()
	{
		$select = $this->select();
		$select->from($this->_name, array('iso1_code', 'name'))
			->order('name');
		
		return $this->fetchAll($select); 
	}
	
}