<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 17/08/2015
 * Time: 16:38
 */
class Unet_Megamenu_Block_Adminhtml_Megamenu_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = "megamenu";
        $this->_controller = "adminhtml_megamenu";
        $this->_updateButton('save', 'label', $this->__('Save Item'));
        $this->_updateButton('delete', 'label', $this->__('Delete Item'));
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productsselector_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productsselector_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productsselector_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    public function getHeaderText()
    {
        if (Mage::registry('megamenu') && Mage::registry('megamenu')->getItem_id()) {
            return $this->__('Edit ').Mage::registry('megamenu')->getItem_name();
        } else {
            return $this->__('New Item');
        }
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
}
