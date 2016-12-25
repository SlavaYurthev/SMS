<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Adminhtml_Sms_SendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction(){
		$helper = Mage::helper('sy_sms');
		if($helper->sendOrderSms(
				$this->getRequest()->getParam('order_id'),
				$this->getRequest()->getParam('to'),
				$this->getRequest()->getParam('text')
			)){
			Mage::getSingleton('adminhtml/session')->addSuccess($helper->__('Sent'));
		}
		else{
			Mage::getSingleton('adminhtml/session')->addError($helper->__('Error'));
		}
		$this->_redirect('adminhtml/sales_order/view', array('order_id'=>$this->getRequest()->getParam('order_id')));
	}
	public function sales_massAction(){
		$order_ids = $this->getRequest()->getParam('order_ids');
		$helper = Mage::helper('sy_sms');
		if($order_ids && count($order_ids)>0){
			foreach ($order_ids as $order_id) {
				$_order = Mage::getModel('sales/order')->load($order_id);
				$increment_id = $_order->getData('increment_id');
				$telephone = $_order->getTelephone();
				$shipping_address = $_order = $_order->getShippingAddress();
				$billing_address = $_order = $_order->getBillingAddress();
				if($this->getRequest()->getParam('telephone_type') == 'billing_address'){
					$telephone = $billing_address->getTelephone();
				}
				elseif($this->getRequest()->getParam('telephone_type') == 'shipping_address'){
					$telephone = $shipping_address->getTelephone();
				}
				$block = new SY_SMS_Block_Adminhtml_Convert;
				$block->setTemplateIdentifier($this->getRequest()->getParam('template'));
				$block->setModelId($order_id);
				$msg = $block->toHtml();
				if($helper->sendOrderSms($order_id, $telephone, $msg) == true){
					Mage::getSingleton('adminhtml/session')->addSuccess(
							$helper->__('Success').' '.$helper->__('Order # %s', $increment_id)
						);
				}
				else{
					Mage::getSingleton('adminhtml/session')->addError(
							$helper->__('Error').' '.$helper->__('Order # %s', $increment_id)
						);
				}
			}
		}
		$this->_redirect('adminhtml/sales_order');
	}
}