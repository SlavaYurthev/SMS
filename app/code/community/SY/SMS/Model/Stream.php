<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Model_Stream extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sy_sms/stream');
    }
}