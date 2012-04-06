<?php
class SettingsController extends Zend_Controller_Action
{
	public function indexAction()
	{
		// Displays the icon panel for settings
	}
	
	public function companyAction()
	{
		$country_table = new ZendInvoices_Db_Table_Countries();
		$currency_table = new ZendInvoices_Db_Table_Currencies();
		
		$this->view->countries = $country_table->getCountryList();
		$this->view->currencies = $currency_table->getCurrencyList();
		
		$request = $this->getRequest();
        if ($request->isPost()) {
        	// ToDo: Save to database
        }
        
        // ToDo: Load database records and assign to view
	}
	
	public function taxesAction()
	{
		// Add a script to add new tax rows
		$this->view->headScript()->appendScript("
		$(document).ready(function() {
			var i = 1;
			$(\"a.add-link\").click(function() {
  				$(\"#taxes-table tr:last\").clone().find(\"input\").each(function() {
    				$(this).val('').attr('name', function(_, id) { return id + i });
  				}).end().appendTo(\"#taxes-table\");
  				i++;
			});
			
			$(\"a.delete-link\").live(\"click\", function() {
				$(this).parent().parent().remove();
			});​
		});​");
		
		$request = $this->getRequest();
        if ($request->isPost()) {
        	$taxes = array();
        	$params = $request->getParams();
        	for ($i=0;$i<count($params['description']);$i++) {
        		$taxes[] = array(
        			'id'			=> $params['tax_id'][$i],
        			'description'	=> $params['description'][$i],
        			'amount'		=> $params['amount1'][$i],
        			'amount_2'		=> $params['amount2'][$i]
        		);
        	}
        	
        	// ToDo: Save taxes
        }
        
        $taxes_table = new ZendInvoices_Db_table_Taxes();
        $this->view->taxes = $taxes_table->fetchAll();
	}
}