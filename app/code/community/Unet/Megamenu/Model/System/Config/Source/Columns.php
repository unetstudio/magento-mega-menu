<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 12/08/2015
 * Time: 09:45
 */
class Unet_Megamenu_Model_System_Config_Source_Columns
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(

            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Left')),
            array('value' => 2, 'label'=>Mage::helper('adminhtml')->__('Content')),
            array('value' => 3, 'label'=>Mage::helper('adminhtml')->__('Right')),
        );
    }

}
