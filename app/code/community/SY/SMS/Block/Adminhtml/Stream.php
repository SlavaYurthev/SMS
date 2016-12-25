<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Stream extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	protected function _construct(){
		parent::_construct();

		$helper = Mage::helper('sy_sms');
		$this->_blockGroup = 'sy_sms';
		$this->_controller = 'adminhtml_stream';

		$this->_headerText = $helper->__('Stream');
		$this->_addButtonLabel = $helper->__('Send Message');
	}
}