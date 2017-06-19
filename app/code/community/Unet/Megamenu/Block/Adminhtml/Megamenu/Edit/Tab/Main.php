<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 17/08/2015
 * Time: 16:41
 */
class Unet_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    protected function _prepareForm()
    {
        $model = Mage::registry('megamenu');

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('item_main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('megamenu')->__('General Infomation')
        ));

        if ($model->getItem_id()) {
            $fieldset->addField('item_id', 'hidden', array(
                'name' => 'item_id',
            ));
        }

        $fieldset->addField('item_name', 'text', array(
            'name'     => 'item_name',
            'label'    => Mage::helper('megamenu')->__('Name'),
            'required' => true,
            'tabindex' => 1,
        ));

//        $fieldset->addField('item_link', 'text', array(
//            'name'     => 'item_link',
//            'label'    => Mage::helper('megamenu')->__('Link'),
//            'required' => false,
//            'tabindex' => 2,
//        ));

        $fieldset->addField('sort_order', 'text', array(
            'name'     => 'sort_order',
            'label'    => Mage::helper('megamenu')->__('Sort Order'),
            'required' => true,
            'tabindex' => 3,
        ));

        $fieldset->addField('menu_type', 'select', array(
            'label'     => Mage::helper('adminhtml')->__('Menu Type'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'menu_type',
            'values' => Mage::getModel('megamenu/megamenu')->toMenuTypeOption(),
            'after_element_html' => '<small>Position of menu</small>',
            'tabindex' => 4
        ));

        $fieldset->addField('status', 'select', array(
            'name'     => 'status',
            'label'    => Mage::helper('megamenu')->__('Status'),
            'required' => true,
            'values' => Mage::getModel('megamenu/megamenu')->toStatusOption(),
            'tabindex' => 5,
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }


    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('General Infomation');
    }

    public function getTabTitle()
    {
        return Mage::helper('adminhtml')->__('General Infomation');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}