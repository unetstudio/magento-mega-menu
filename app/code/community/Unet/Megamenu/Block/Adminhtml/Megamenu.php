<?php
/** @package Megamenu */
class Unet_Megamenu_Block_Adminhtml_Megamenu extends Mage_Adminhtml_Block_Widget_Grid_Container {
    public function __construct(){
        $this->_blockGroup = "megamenu";
        $this->_controller = "adminhtml_megamenu";
        $this->_headerText = $this->__('Megamenu');
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Create Item');
        parent::__construct();
    }
}