<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Adminhtml_Sms_AjaxController extends Mage_Adminhtml_Controller_Action
{
	public function templateAction(){
		$this->loadLayout();
		$block = new SY_SMS_Block_Adminhtml_Convert;
		$block->setTemplateIdentifier($this->getRequest()->getParam('template'));
		$block->setModelId($this->getRequest()->getParam('order_id'));
		$response = $block->json();
		$this->getResponse()->setHeader('Content-type', 'application/json');
		$this->getResponse()->setBody($response);
	}
}