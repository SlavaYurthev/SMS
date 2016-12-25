<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Model_Smsclub extends Mage_Core_Model_Abstract {
	const URI = 'https://gate.smsclub.mobi';
	const SEND = 'token/';
	const STATUS = 'token/state.php';
	protected $params;
	public $helper;
	public function __construct(){
		$this->helper = Mage::helper('sy_sms');
		$this->params = array(
				'username' => $this->helper->getStoreConfig('username'),
				'token' => $this->helper->getStoreConfig('token'),
				'from' => $this->helper->getStoreConfig('sender_name')
			);
	}
	public function status($id){
		$request = $this->request(array('smscid'=>$id), self::STATUS);
		if(isset($request[0])){
			$request = str_replace($id.":", "", $request[0]);
			$request = trim($request);
			return $request;
		}
	}
	public function send($to, $text){
		$text = iconv("UTF-8", "windows-1251", $text);
		$request = $this->request(array('to'=>$to,'text'=>$text), self::SEND);
		if(isset($request[0])){
			return $request[0];
		}
	}
	protected function request($params = array(), $method){
		$ch = curl_init();
		$url = self::URI.DS.$method;
		if($params && count($params)>0){
			$url .= '?'.http_build_query(array_merge($params, $this->params));
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		// delete start and end constants in smsclub response string
		$response = preg_replace('/<br\s?\/?>/ius', "\n", $response);
		$response = trim($response);
		$response = explode("\n", $response);
		array_shift($response);
		array_pop($response);
		return $response;
	}
}