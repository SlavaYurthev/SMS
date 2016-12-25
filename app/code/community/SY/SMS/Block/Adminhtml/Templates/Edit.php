<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Templates_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	protected function _construct(){
		$this->_blockGroup = 'sy_sms';
		$this->_controller = 'adminhtml_templates';
	}
	public function getHeaderText(){
		$helper = Mage::helper('sy_sms');
		$model = Mage::registry('current_template');
		if ($model->getId()) {
			return $helper->__("Edit Template '%s'", $this->escapeHtml($model->getData('identifier')));
		} else {
			return $helper->__("Add Template");
		}
	}
}