<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 12/08/2015
 * Time: 09:45
 */
class Unet_Megamenu_Model_System_Config_Source_Position
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(

            array('value' => 'all', 'label'=>Mage::helper('adminhtml')->__('All Position')),
            array('value' => 'select', 'label'=>Mage::helper('adminhtml')->__('Select Option')),
        );
    }
}
