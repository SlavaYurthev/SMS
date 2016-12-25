<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Model_System_Config_Address_Type {
	public function toOptionArray(){
		$helper = Mage::helper('sy_sms');
		$templates = array(false, 1=>$helper->__('Billing Address'), 2=>$helper->__('Shipping Address'));
		return $templates;
	}
}