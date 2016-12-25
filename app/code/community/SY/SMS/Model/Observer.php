<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
date_default_timezone_set('Europe/Kiev');
class SY_SMS_Model_Observer extends Mage_Core_Model_Abstract {
	// Little trick to add getChildHtml('myblock') into sales/order/view.phtml
	public function addSmsHistoryBlockToSalesOrderViewTab(Varien_Event_Observer $observer){
		$block = $observer->getBlock();
		if (($block->getNameInLayout() == 'order_info') && ($child = $block->getChild('sy.order.info.sms.history'))) {
			$transport = $observer->getTransport();
			if($transport) {
				$html = $transport->getHtml();
				$html .= $child->toHtml();
				$transport->setHtml($html);
			}
		}
	}
	public function updateStatuses(){
		$collection = Mage::getModel('sy_sms/stream')->getCollection();
		$collection->addFieldToFilter('sent', array(
				'from'=> strtotime('-1 day', time()),
				'to'=> time(),
				'datetime' => true
			));
		$collection->addFieldToFilter('external_id', array('notnull'=>true));
		$collection->addFieldToFilter('recived', array('null'=>true));
		if($collection->count()>0){
			$client = new SY_SMS_Model_Client;
			foreach ($collection as $sms) {
				$external_ids = $sms->getData('external_id');
				// Can be split to many parts
				$external_ids = explode(";", $external_ids);
				if(count($external_ids)>0){
					foreach ($external_ids as $external_id) {
						@$datetime = $client->status($external_id);
						if($datetime && Mage::helper('sy_sms')->isDatetime($datetime)){
							$sms->setData('recived', time());
							$sms->save();
						}
						// Only for first part
						break;
					}
				}
			}
		}
	}
	public function addMassActionsToSalesOrderGrid(Varien_Event_Observer $observer){
		if(Mage::helper('sy_sms')->getStoreConfig('active') == "1"){
			$block = $observer->getBlock();
		    if (!isset($block)) {
		        return $this;
		    }
		    if($block instanceof Mage_Adminhtml_Block_Widget_Grid_Massaction && 
		    	$block->getRequest()->getControllerName() == 'sales_order'){
		    	$collection = Mage::getModel('sy_sms/template')->getCollection();
		    	$collection->addFieldToFilter('model','sales/order');
		    	if($collection->count()>0){
		    		foreach ($collection as $template) {
				    	$block->addItem('sms_mass_sending_billing'.$template->getData('identifier'), array(
							'label' => Mage::helper('sy_sms')->__('SMS: %s (Billing Address Telephone)', $template->getData('label')),
							'url' => $block->getUrl('adminhtml/sms_send/sales_mass', array(
									'template'=>$template->getData('identifier'),
									'telephone_type'=>'billing_address'
								))
						));
				    	$block->addItem('sms_mass_sending_shipping'.$template->getData('identifier'), array(
							'label' => Mage::helper('sy_sms')->__('SMS: %s (Shipping Address Telephone)', $template->getData('label')),
							'url' => $block->getUrl('adminhtml/sms_send/sales_mass', array(
									'template'=>$template->getData('identifier'),
									'telephone_type'=>'shipping_address'
								))
						));
		    		}
		    	}
		    }
		}
	}
	public function onOrderPlaceAfter(Varien_Event_Observer $observer){
		$order = $observer->getOrder();
		$addressType = Mage::getStoreConfig('sy_sms/automatic_events/place_order_address_type');
		$address = false;
		$helper = Mage::helper('sy_sms');
		switch ($addressType) {
			case '1':
				$address = $order->getBillingAddress();
				break;

			case '2':
				$address = $order->getShippingAddress();
				break;
		}
		if(is_object($address)){
			if((bool)Mage::getStoreConfig('sy_sms/automatic_events/place_order') !== false){
				$telephone = $address->getTelephone();
				$block = new SY_SMS_Block_Adminhtml_Convert;
				$block->setTemplateIdentifier(Mage::getStoreConfig('sy_sms/automatic_events/place_order'));
				$block->setModelId($order->getId());
				$msg = $block->toHtml();
				@$helper->sendOrderSms($order->getId(),$telephone,$msg);
			}
		}
	}
}