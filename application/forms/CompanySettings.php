<?php
class Application_Form_CompanySettings extends Zend_Form
{
    public function init()
    {
        $this->setName("company");
        $this->setMethod('post');
             
        $this->addElement('text', 'name', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 100)),
            ),
            'required'   => true,
            'label'      => 'Company Name:'
        ));

        $this->addElement('text', 'vat_number', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 16)),
            ),
            'required'   => false,
            'label'      => 'Vat Number:'
        ));
        
        $this->addElement('text', 'street1', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required'   => false
        ));
       
       $this->addElement('text', 'street2', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required'   => false
        ));
        
        $this->addElement('text', 'city', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required'   => false
        ));
        
        $this->addElement('text', 'state', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'required'   => false
        ));
        
        $this->addElement('text', 'zip', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => false
        ));
        
        $this->addElement('text', 'country_code', array(
            'filters'    => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array('StringLength', false, 2),
            ),
            'required'   => true
        ));
        
        $this->addElement('text', 'phone', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 15)),
            ),
            'required'   => false
        ));
        
        $this->addElement('text', 'mobile', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 15)),
            ),
            'required'   => false
        ));
        
        $this->addElement('text', 'fax', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 15)),
            ),
            'required'   => false
        ));
        
        $this->addElement('text', 'email', array(
            'filters'    => array('StringTrim', 'stringToLower'),
        	'validators' => array(
        		array('emailAddress', false)
        	),
            'required'   => false
        ));
        
        $this->addElement('text', 'currency', array(
            'filters'    => array('StringTrim', 'StringToUpper'),
            'validators' => array(
                array('StringLength', false, 3),
            ),
            'required'   => true
        ));

        $this->addElement('submit', 'save', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Save',
        ));
               
    }
}
