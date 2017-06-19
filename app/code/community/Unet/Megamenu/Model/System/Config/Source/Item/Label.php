<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 27/08/2015
 * Time: 09:23
 */
class Unet_Megamenu_Model_System_Config_Source_Item_Label {
    public function toOptionArray(){
        return array(
            array(
                'value' => 'none',
                'label' =>  Mage::helper('adminhtml')->__('Normal'),
            ),
            array(
                'value' => 'uppercase',
                'label' =>  Mage::helper('adminhtml')->__('Uppercase'),
            ),
            array(
                'value' => 'lowercase',
                'label' =>  Mage::helper('adminhtml')->__('Lowercase'),
            ),
            array(
                'value' => 'capitalize',
                'label' =>  Mage::helper('adminhtml')->__('Capitalize'),
            ),
        );
    }
}