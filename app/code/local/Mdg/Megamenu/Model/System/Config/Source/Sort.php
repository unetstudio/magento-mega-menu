<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 12/08/2015
 * Time: 16:12
 */
class Mdg_Megamenu_Model_System_Config_Source_Sort {
    public function toOptionArray(){
        return array(
            array('value' => 'none', 'label' => Mage::helper('adminhtml')->__('Normal')),
            array('value' => 'date_newest', 'label' => Mage::helper('adminhtml')->__('Date (Newest)')),
            array('value' => 'date_oldest', 'label' => Mage::helper('adminhtml')->__('Date (Oldest)')),
            array('value' => 'name_az', 'label' => Mage::helper('adminhtml')->__('Name (A-Z)')),
            array('value' => 'name_za', 'label' => Mage::helper('adminhtml')->__('Name (Z-A)')),
            array('value' => 'price_in', 'label' => Mage::helper('adminhtml')->__('Price (Increment)')),
            array('value' => 'price_de', 'label' => Mage::helper('adminhtml')->__('Price (Decrement)')),
        );
    }
}