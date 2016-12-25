<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_Stream_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setDefaultSort('id');
		$this->setDefaultDir('DESC');
	}
	protected function _prepareCollection(){
		$collection = Mage::getModel('sy_sms/stream')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns(){
		$helper = Mage::helper('sy_sms');
		$this->addColumn('id', array(
			'header' => $helper->__('ID'),
			'index' => 'id'
		));
		$this->addColumn('external_id', array(
			'header' => $helper->__('External ID'),
			'index' => 'external_id',
			'type' => 'text',
		));
		$this->addColumn('reciver', array(
			'header' => $helper->__('Reciver'),
			'index' => 'reciver',
			'type' => 'text',
		));
		$this->addColumn('msg', array(
			'header' => $helper->__('Message'),
			'index' => 'msg',
			'type' => 'text',
		));
		$this->addColumn('sent', array(
			'header' => $helper->__('Sent'),
			'index' => 'sent',
			'type' => 'date'
		));
		$this->addColumn('recived', array(
			'header' => $helper->__('Recived'),
			'index' => 'recived',
			'type' => 'date'
		));
		return parent::_prepareColumns();
	}
	public function getRowUrl($model){
		return 'javascript:void(0)';
	}
}