<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
date_default_timezone_set('Europe/Kiev');
class SY_SMS_Helper_Data extends Mage_Core_Helper_Abstract {
	static public function getDatetime(){
		return date("Y-m-d H:i:s");
	}
	public function getStoreConfig($key){
		return Mage::getStoreConfig('sy_sms/general/'.$key);
	}
	public function getModels(){
		return array(
				array('label'=>$this->__('Sales'), 'value'=>'sales/order')
			);
	}
	public function isDatetime($string){
		return (date('Y-m-d H:i:s', strtotime($string)) == $string);
	}
	public function getModelsArray(){
		$return = array();
		if($models = $this->getModels()){
			if(count($models)>0){
				foreach ($models as $model) {
					$return[$model['value']] = $model['label'];
				}
				return $return;
			}
		}
	}
	public function sendSms($to, $text){
		$client = new SY_SMS_Model_Client;
		// Add Contry Code
		$to = $this->getStoreConfig('country_code').$to;
		// Delete non-digit symbols or +
		$to = preg_replace("/[^0-9+]/", "", $to);
		$externalId = $client->send($to,$text);
		return $externalId;
	}
	public function sendOrderSms($orderId, $to, $text){
		$client = new SY_SMS_Model_Client;
		// Add Contry Code
		$to = $this->getStoreConfig('country_code').$to;
		// Delete non-digit symbols or +
		$to = preg_replace("/[^0-9+]/", "", $to);
		try {
			$externalId = $client->send($to,$text);
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($helper->__('Error'));
		}
		if((bool)$externalId !== false){
			$model = Mage::getModel('sy_sms/stream');
			$model->setData(
					array(
						'reciver' => $to,
						'msg' => $text,
						'sent' => time(),
						'external_id' => $externalId
					)
				);
			$model->save();
			$id = $model->getId();
			$model = Mage::getModel('sy_sms/order');
			$model->setData(
					array(
						'order_id' => $orderId,
						'sms_id' => $id
					)
				);
			$model->save();
			return true;
		}
	}
}