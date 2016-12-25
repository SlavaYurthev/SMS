<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Adminhtml_Sms_VariablesController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction(){
		$this->loadLayout()->_setActiveMenu('sy');
		$this->getLayout()->getBlock('head')->setTitle(Mage::helper('sy_sms')->__('Variables Management'));
		$this->_addContent($this->getLayout()->createBlock('sy_sms/adminhtml_variables'));
		$this->renderLayout();
	}
	public function newAction(){
		$this->_forward('edit');
	}
	public function editAction(){
		$id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getModel('sy_sms/variable');
        if($data = Mage::getSingleton('adminhtml/session')->getFormData()){
            $model->setData($data)->setId($id);
        } else {
            $model->load($id);
        }
        Mage::register('current_variable', $model);
        $this->loadLayout()->_setActiveMenu('sy_sms');
		$this->getLayout()->getBlock('head')->setTitle(Mage::helper('sy_sms')->__('Variables Management'));
        $this->_addLeft($this->getLayout()->createBlock('sy_sms/adminhtml_variables_edit_tabs'));
        $this->_addContent($this->getLayout()->createBlock('sy_sms/adminhtml_variables_edit'));
        $this->renderLayout();
	}
	public function saveAction(){
		if ($data = $this->getRequest()->getPost()) {
			try {
				$model = Mage::getModel('sy_sms/variable');
				$model->setData($data)->setId($this->getRequest()->getParam('id'));
				$model->save();

				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Variable was saved successfully'));
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
	public function deleteAction(){
		if ($id = $this->getRequest()->getParam('id')) {
			try {
				Mage::getModel('sy_sms/variable')->setId($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Variable was deleted successfully'));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $id));
			}
		}
		$this->_redirect('*/*/');
	}
}