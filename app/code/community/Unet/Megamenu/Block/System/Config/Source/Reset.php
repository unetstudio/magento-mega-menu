<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 27/08/2015
 * Time: 14:24
 */
class Unet_Megamenu_Block_System_Config_Source_Reset extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        $url = $this->getUrl('adminhtml/megamenu/reset'); //

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setClass('scalable')
            ->setLabel('Restore Default')
            ->setOnClick("setLocation('$url')")
            ->toHtml();

        return $html;
    }
}