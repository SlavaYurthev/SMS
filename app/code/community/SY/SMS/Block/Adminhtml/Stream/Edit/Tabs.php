<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Stream_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		$helper = Mage::helper('sy_sms');

		parent::__construct();
		$this->setId('stream_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($helper->__('SMS Information'));
	}
	protected function _prepareLayout(){
		$helper = Mage::helper('sy_sms');

		$this->addTab('general_section', array(
			'label' => $helper->__('General Information'),
			'title' => $helper->__('General Information'),
			'content' => $this->getLayout()->createBlock('sy_sms/adminhtml_stream_edit_tabs_general')->toHtml(),
		));
		return parent::_prepareLayout();
	}
}