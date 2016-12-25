<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Convert extends Mage_Adminhtml_Block_Template {
	protected $model;
	protected $template;
	public function setTemplateIdentifier($identifier){
		$template = Mage::getModel('sy_sms/template')->load($identifier, 'identifier');
		if($template->getId()){
			$this->template = $template;
		}
		return $this;
	}
	public function setModelId($id){
		if($this->template && $this->template->getData('model')){
			try {
				$this->model = Mage::getModel($this->template->getData('model'))->load($id);
			} catch (Exception $e) {}
		}
		return $this;
	}
	public function format(){
		$filter = Mage::getModel('cms/template_filter');
		$array = array();
		$variables = Mage::getModel('sy_sms/variable')->getCollection();
		$variables->addFieldToFilter('model', $this->template->getData('model'));
		if($variables->count()>0){
			foreach ($variables as $variable) {
				$path = $variable->getData('path');
				// Split path string to array
				$keys = explode("/", $path);
				// set model as default value
				$value = $this->model;
				if(count($keys)>0){
					foreach ($keys as $key) {
						// rewrite value every key
						if($key == 'billing_address'){
							$value = $value->getBillingAddress();
						}
						elseif($key == 'shipping_address'){
							$value = $value->getShippingAddress();
						}
						else{
							$value = $value->getData($key);
						}
					}
					// and pass to filter
					$array[$variable->getData('identifier')] = $value;
				}
			}
		}
		$filter->setVariables($array);
		return $filter->filter($this->template->getData('msg'));
	}
	public function _toHtml(){
		if($this->model && $this->template && $this->model->getId() && $this->template->getId()){
			return $this->format();
		}
	}
	public function json(){
		$msg = '';
		if($this->model && $this->template && $this->model->getId() && $this->template->getId()){
			$msg = $this->format();
		}
		return json_encode(array('msg'=>$msg));
	}
}