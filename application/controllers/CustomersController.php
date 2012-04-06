<?php
class CustomersController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$customers_table = new ZendInvoices_Db_Table_Customers();
		
		$paginator = $customers_table->getPaginator();
		$paginator->setItemCountPerPage(20);
		$paginator->setCurrentPageNumber($this->_getParam('page'));
		
		$this->view->paginator = $paginator;
	}
	
	public function addAction()
	{
		$country_table = new ZendInvoices_Db_Table_Countries();
		$currency_table = new ZendInvoices_Db_Table_Currencies();
		$payment_types_table = new ZendInvoices_Db_Table_PaymentTypes();
		
		$this->view->countries = $country_table->getCountryList();
		$this->view->currencies = $currency_table->getCurrencyList();
		$this->view->payment_types = $payment_types_table->getPaymentTypeList();
	}
}