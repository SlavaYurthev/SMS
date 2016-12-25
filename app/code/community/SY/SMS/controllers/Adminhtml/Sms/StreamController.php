<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
date_default_timezone_set('Europe/Kiev');
class SY_SMS_Adminhtml_Sms_StreamController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction(){
		$this->loadLayout()->_setActiveMenu('sy');
		$this->getLayout()->getBlock('head')->setTitle(Mage::helper('sy_sms')->__('Stream'));
		$this->_addContent($this->getLayout()->createBlock('sy_sms/adminhtml_stream'));
		$this->renderLayout();
	}
	public function newAction(){
		$id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('sy_sms/stream');
        if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
            $model->setData($data)->setId($id);
        } else {
            $model->load($id);
        }
        Mage::register('current_message', $model);
        $this->loadLayout()->_setActiveMenu('sy_sms');
		$this->getLayout()->getBlock('head')->setTitle(Mage::helper('sy_sms')->__('Send Message'));
        $this->_addLeft($this->getLayout()->createBlock('sy_sms/adminhtml_stream_edit_tabs'));
        $this->_addContent($this->getLayout()->createBlock('sy_sms/adminhtml_stream_edit'));
        $this->renderLayout();
	}
	public function saveAction(){
		if ($data = $this->getRequest()->getPost()) {
			$helper = Mage::helper('sy_sms');
			try {
				$model = Mage::getModel('sy_sms/stream');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				$model->setData('sent', time());
				if(@$externalId = $helper->sendSms(
					$this->getRequest()->getParam('reciver'),
					$this->getRequest()->getParam('msg'))){
					if($externalId){
						$model->setData('external_id', $externalId);
						$model->save();
						Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Message was sent successfully'));
					}
					else{
						Mage::getSingleton('adminhtml/session')->addError($this->__('Gateway not take the request'));
					}
				}
				else{
					Mage::getSingleton('adminhtml/session')->addError($this->__('Gateway not take the request'));
				}

				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array(
					'id' => $this->getRequest()->getParam('id')
				));
			}
			return;
		}
		Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}
}