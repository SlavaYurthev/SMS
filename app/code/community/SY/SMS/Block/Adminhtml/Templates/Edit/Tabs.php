<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Templates_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		$helper = Mage::helper('sy_sms');

		parent::__construct();
		$this->setId('template_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($helper->__('Template Information'));
	}
	protected function _prepareLayout(){
		$helper = Mage::helper('sy_sms');

		$this->addTab('general_section', array(
			'label' => $helper->__('General Information'),
			'title' => $helper->__('General Information'),
			'content' => $this->getLayout()->createBlock('sy_sms/adminhtml_templates_edit_tabs_general')->toHtml(),
		));
		return parent::_prepareLayout();
	}
}