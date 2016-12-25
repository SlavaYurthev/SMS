<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Variables extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	protected function _construct(){
		parent::_construct();

		$helper = Mage::helper('sy_sms');
		$this->_blockGroup = 'sy_sms';
		$this->_controller = 'adminhtml_variables';

		$this->_headerText = $helper->__('Variables Management');
		$this->_addButtonLabel = $helper->__('Add Variable');
	}
}