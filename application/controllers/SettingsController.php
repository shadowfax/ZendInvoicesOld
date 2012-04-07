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
		$company_table = new ZendInvoices_Db_Table_Companies();
	
		$this->view->countries = $country_table->getCountryList();
		$this->view->currencies = $currency_table->getCurrencyList();
		
		$request = $this->getRequest();
        if ($request->isPost()) {
        	// Initialize variable 
        	$saved = false;
        	
        	// I only use Zend_Form for validation
        	$form = new Application_Form_CompanySettings();
        	$form_data = $this->_request->getParams();
        	
        	if($form->isValid($form_data)) {
        		// ToDo: Save to database
        		$company_data = array(
        			'name'			=> $form->getValue('name'),
        			'vat_number'	=> $form->getValue('vat_number'),
        			'street1'		=> $form->getValue('street1'),
        			'street2'		=> $form->getValue('street2'),
        			'city'			=> $form->getValue('city'),
        			'state'			=> $form->getValue('state'),
        			'zip'			=> $form->getValue('zip'),
        			'country_code'	=> $form->getValue('country_code'),
        			'phone'			=> $form->getValue('phone'),
        			'mobile'		=> $form->getValue('mobile'),
        			'fax'			=> $form->getValue('fax'),
        			'email'			=> $form->getValue('email'),
        			'currency'		=> $form->getValue('currency')
        		);
        		
        		if (is_numeric($form_data['id']) && ($form_data['id'] > 0)) {
        			try {
        				$saved = $company_table->update($company_data, $form_data['id']);
        			} catch (Exception $e) {
        				throw $e;
        			}
        		} else {
        			try {
        				// Set it as enabled
        				$company_data['enabled'] = 1;
        				
        				$saved = $company_table->insert($company_data);
        				if ($saved) {
        					$form_data['id'] = $company_table->lastInsertedId();
        				}
        			} catch (Exception $e){
        				throw $e;
        			}
        		}
        	}
        	
        	if ($saved) {
        	
        	} else {
        		// ToDo: Display errors
        	}
        }
        
        // ToDo: In a future allow multiple companies
        if (isset($form_data)) $this->view->company = $form_data;
        else $this->view->company = $company_table->findById(1);
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