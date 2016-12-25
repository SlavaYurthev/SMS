<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Stream_Edit_Tabs_General extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		$helper = Mage::helper('sy_sms');
		$model = Mage::registry('current_message');

		$form = new Varien_Data_Form();
		$fieldset = $form->addFieldset('general_form', array(
					'legend' => $helper->__('General Information')
				));

		$fieldset->addField('reciver', 'text', array(
			'label' => $helper->__('Reciver'),
			'required' => true,
			'name' => 'reciver',
		));
		$size = Mage::getStoreConfig('sy_sms/general/length');
		$fieldset->addField('message', 'editor', array(
			'label' => $helper->__('Message'),
			'required' => true,
			'name' => 'msg',
			'onchange' => "sy.sms.updateLength(this, $('message_counter'), '".$size."')",
			'onkeyup' => "sy.sms.updateLength(this, $('message_counter'), '".$size."')",
			'after_element_html' => Mage::app()->getLayout()->createBlock('adminhtml/template')->setTemplate(
					'sy/sms/stream/form/counter.phtml'
				)->toHtml()
		));

		$form->setValues($model->getData());
		$this->setForm($form);

		return parent::_prepareForm();
	}
}