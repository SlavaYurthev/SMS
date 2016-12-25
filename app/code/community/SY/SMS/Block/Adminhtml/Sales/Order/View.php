<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Sales_Order_View extends Mage_Core_Block_Template {
	public function getOrder(){
		return Mage::registry('current_order');
	}
	public function getHistory(){
		$order = Mage::registry('current_order');
		$collection = Mage::getModel('sy_sms/order')->getCollection();
		$collection->addFieldToFilter('order_id', $order->getId());
		$collection->getSelect()
			->joinLeft(
				array("t1" => Mage::getSingleton('core/resource')->getTableName('sy_sms_stream')), 
				"main_table.sms_id = t1.id", 
				array(
						"msg" => "t1.msg",
						"sent" => "t1.sent",
						"recived" => "t1.recived",
					)
			)
			->order('sent desc');
		return $collection;
	}
	public function getTelephones(){
		$order = Mage::registry('current_order');
		$collection = new Varien_Data_Collection;
		$item = new Varien_Object;
		$item->addData(array('telephone' => $order->getBillingAddress()->getTelephone()));
		$item->addData(array(
						'type' => $this->__('Billing Telephone: %s', $order->getBillingAddress()->getTelephone())
					));
		$collection->addItem($item);
		$item = new Varien_Object;
		$item->addData(array('telephone' => $order->getShippingAddress()->getTelephone()));
		$item->addData(array(
						'type' => $this->__('Shipping Telephone: %s', $order->getShippingAddress()->getTelephone())
					));
		$collection->addItem($item);
		return $collection;
	}
	public function getTemplates(){
		$collection = Mage::getModel('sy_sms/template')->getCollection();
		$collection->addFieldToFilter('model','sales/order');
		return $collection;
	}
}