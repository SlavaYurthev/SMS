<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Model_System_Config_Place_Order {
	public function toOptionArray(){
		$templates = array(false);
		$collection = Mage::getModel('sy_sms/template')->getCollection();
		if($collection->count()>0){
			foreach ($collection as $template) {
				$templates[$template->getData('identifier')] = $template->getData('label');
			}
		}
		return $templates;
	}
}