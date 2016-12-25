<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Variables_Edit_Tabs_General extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		$helper = Mage::helper('sy_sms');
		$model = Mage::registry('current_variable');

		$form = new Varien_Data_Form();
		$fieldset = $form->addFieldset('general_form', array(
					'legend' => $helper->__('General Information')
				));

		$fieldset->addField('identifier', 'text', array(
			'label' => $helper->__('Identifier'),
			'required' => true,
			'name' => 'identifier',
		));

		$fieldset->addField('label', 'text', array(
			'label' => $helper->__('Label'),
			'required' => true,
			'name' => 'label',
		));

		$fieldset->addField('model', 'select', array(
			'label' => $helper->__('Model'),
			'required' => true,
			'name' => 'model',
			'values' => $helper->getModelsArray()
		));

		$fieldset->addField('path', 'text', array(
			'label' => $helper->__('Path'),
			'required' => true,
			'name' => 'path',
		));

		$form->setValues($model->getData());
		$this->setForm($form);

		return parent::_prepareForm();
	}
}