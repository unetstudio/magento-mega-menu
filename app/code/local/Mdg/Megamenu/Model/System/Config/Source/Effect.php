<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 23/08/2015
 * Time: 21:04
 */
class Mdg_Megamenu_Model_System_Config_Source_Effect {
    public function toOptionArray(){
        return array(
            array(
                'value' => 'hover',
                'label' => Mage::helper('adminhtml')->__('Hover'),
            ),
            array(
                'value' => 'click',
                'label' => Mage::helper('adminhtml')->__('Click'),
            ),
        );
    }
}