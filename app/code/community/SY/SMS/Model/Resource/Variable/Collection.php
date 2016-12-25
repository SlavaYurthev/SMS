<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Model_Resource_Variable_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sy_sms/variable');
    }
}