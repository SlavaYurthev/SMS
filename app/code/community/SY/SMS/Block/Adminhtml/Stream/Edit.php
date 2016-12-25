<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Stream_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	protected function _construct(){
		$this->_blockGroup = 'sy_sms';
		$this->_controller = 'adminhtml_stream';
	}
	public function getHeaderText(){
		$helper = Mage::helper('sy_sms');
		$model = Mage::registry('current_message');
		return $helper->__("Send Message");
	}
}