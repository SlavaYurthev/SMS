<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
class SY_SMS_Block_Adminhtml_System_Config_Registration_Renderer extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
                'label'=>$this->__('Registration'),
                'onclick'=>'referalRedirect()'
            ));
        $js = '<script>';
        $js .= 'referalRedirect = function(){';
        $js .= 'window.open("https://smsclub.mobi/auth?id_referral=15924#tab-reg","referalRedirect");';
        $js .= '}';
        $js .= '</script>';
        return $button->toHtml().$js;
    }
}