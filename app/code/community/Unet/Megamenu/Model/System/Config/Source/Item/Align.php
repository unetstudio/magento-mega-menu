<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 27/08/2015
 * Time: 09:42
 */
class Unet_Megamenu_Model_System_Config_Source_Item_Align {
    public function toOptionArray(){
        return array(
            array(
                'value' => 'left',
                'label' =>  Mage::helper('adminhtml')->__('Left'),
            ),
            array(
                'value' => 'center',
                'label' =>  Mage::helper('adminhtml')->__('Center'),
            ),
            array(
                'value' => 'right',
                'label' =>  Mage::helper('adminhtml')->__('Right'),
            ),

        );
    }
}