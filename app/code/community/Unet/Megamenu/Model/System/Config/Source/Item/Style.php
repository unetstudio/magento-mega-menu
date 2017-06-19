<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 27/08/2015
 * Time: 09:23
 */
class Unet_Megamenu_Model_System_Config_Source_Item_Style
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'normal',
                'label' =>  Mage::helper('adminhtml')->__('Normal'),
            ),
            array(
                'value' => 'bold',
                'label' =>  Mage::helper('adminhtml')->__('Bold'),
            ),
        );
    }
}
