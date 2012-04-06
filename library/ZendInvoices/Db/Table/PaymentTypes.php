<?php
class ZendInvoices_Db_Table_PaymentTypes extends Zend_Db_Table_Abstract
{
	protected $_name = 'payment_types';
	protected $_primary = 'id';
	
	public function getPaymentTypeList()
	{
		$select = $this->select();
		$select->from($this->_name, array('id', 'description'))
			->order('description');
		
		return $this->fetchAll($select); 
	}

}