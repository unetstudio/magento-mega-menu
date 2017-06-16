<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 17/08/2015
 * Time: 16:41
 */
class Mdg_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Content
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{


    protected function _prepareForm()
    {
        $model = Mage::registry('megamenu');

        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('menu_content', array(
            'legend' => Mage::helper('megamenu')->__('Menu Content')
        ));

        /**
         * Show content type and column
         */
        $fieldset->addField('content_type', 'select', array(
            'name'     => 'content_type',
            'label'    => Mage::helper('megamenu')->__('Main Content Type'),
            'required' => true,
            'values' => Mage::getModel('megamenu/megamenu')->toContentTypeOption(),
            'class' => 'content_type',
            'note' => Mage::helper('megamenu')->__('Select type of item in menu'),
        ));

        /**
         * Show link type
         */
        $fieldset->addField('link_type', 'select', array(
            'name' => 'link_type',
            'label' => Mage::helper('megamenu')->__('Type'),
            'values' => array(
                array(
                    'value' => '',
                    'label' => Mage::helper('megamenu')->__('--Please Select'),
                ),
                array(
                    'value' => 'text', 'label' => 'Text Link',
                ),
                array(
                    'value' => 'page', 'label' => 'Page Link',
                ),
                array(
                    'value' => 'category', 'label' => 'Category Link',
                ),
            ),
        ));
        $fieldset->addField('text_link', 'text', array(
            'name' => 'text_link',
            'label' => Mage::helper('megamenu')->__('Text Link'),
        ));
        $fieldset->addField('page_link', 'select', array(
            'name' => 'page_link',
            'label' => Mage::helper('megamenu')->__('Page'),
            'values' => Mage::getModel('megamenu/megamenu')->toCmsPageOption(),
        ));
        $fieldset->addField('category_link', 'select', array(
            'name' => 'category_link',
            'label' => Mage::helper('megamenu')->__('Category'),
            'values' => Mage::getModel('megamenu/megamenu')->toCategoriesOption(),
        ));
        /**
         * Show content
         */
        $fieldset->addField('contents', 'editor', array(
            'name'      => 'contents',
            'label'     => Mage::helper('megamenu')->__('Content'),
            'title'     => Mage::helper('megamenu')->__('Content'),
            'style'     => 'height:15em',
            'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
            'wysiwyg'   => true,
            'required'  => false,
        ));
        /**
         * Show product
         */
        // Product type
        $fieldset->addField('product_type', 'select', array(
            'name'     => 'product_type',
            'label'    => Mage::helper('megamenu')->__('Product Type'),
            'required' => true,
            'values' => array(
                array(
                    'value' => '',
                    'label' => Mage::helper('megamenu')->__('--Please Select'),
                ),
                array(
                    'value' => 'bestseller', 'label' => 'Product Bestseller'
                ),
                array(
                    'value' => 'mostview', 'label' => 'Product Most View'
                ),
                array(
                    'value' => 'select', 'label' => 'Product Selected'
                ),
            ),
        ));
        $fieldset->addField('column', 'text', array(
            'name'     => 'column',
            'label'    => Mage::helper('megamenu')->__('Number Product'),
            'required' => true,
        ));
        // Product show type
        $fieldset->addField('product_show_type', 'select', array(
            'name'     => 'product_show_type',
            'label'    => Mage::helper('megamenu')->__('Product Show Type'),
            'required' => true,
            'values' => array(
                array(
                    'value' => 'grid', 'label' => 'Product Grid'
                ),
                array(
                    'value' => 'list', 'label' => 'Product Listing'
                ),
            ),
        ));
        // Product Chooser
        $fieldset->addType('product', 'Mdg_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Renderer_Product');
        $action = "getProductChooser('" . Mage::getUrl(
                'adminhtml/promo_widget/chooser/attribute/sku/form/rule_conditions_fieldset',
                array('_secure' => Mage::app()->getStore()->isAdminUrlSecure())
            ) . "?isAjax=true')";
        // Add product SKU text preview
        $fieldset->addField('product_sku', 'product', array(
            'label' => 'Product List',
            'name' => 'product_sku',
            'required' => true,
            'class' => 'rule_conditions_fieldset',
            'readonly' => false,
            'url' => $action,
        ));
        $fieldset->addFieldset('product_chooser', array('legend' => ('')));

        /**
         *  Show category
         */
        $fieldset->addField('category_type', 'select', array(
            'name'     => 'category_type',
            'label'    => Mage::helper('megamenu')->__('Categories Option'),
            'values' => array(
                array('value' => 'all', 'label' => 'List all categories of site'),
                array('value' => 'select', 'label' => 'List all categories selected'),
            ),
            'required' => true,
        ));
        $fieldset->addField('categories_list', 'multiselect', array(
            'name'     => 'categories_list[]',
            'label'    => Mage::helper('megamenu')->__('Categories List'),
            'values' => Mage::getModel('megamenu/megamenu')->toCategoriesOption(),
            'required' => true,
        ));



        /**
         * Set form
         */
        $form->addValues($model->getData());
        $this->setForm($form);
        /**
         * Set dependence
         */
        $this->setChild('form_after',

            $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')

                ->addFieldMap('content_type', 'content_type_id')
                ->addFieldMap('link_type', 'link_id')
                ->addFieldMap('text_link', 'text_id')
                ->addFieldMap('page_link', 'page_id')
                ->addFieldMap('category_link', 'category_id')
                ->addFieldMap('column', 'column_id')
                ->addFieldMap('contents', 'contents_id')
                ->addFieldMap('product_type', 'product_type_id')
                ->addFieldMap('product_show_type', 'product_show_type_id')
                ->addFieldMap('product_sku', 'product_sku_id')
                ->addFieldMap('category_type', 'category_type_id')
                ->addFieldMap('categories_list', 'categories_list_id')
                /**
                 * Show Link
                 */
                ->addFieldDependence('link_id', 'content_type_id', 'link')
                ->addFieldDependence('text_id', 'content_type_id', 'link')
                ->addFieldDependence('text_id', 'link_id', 'text')
                ->addFieldDependence('page_id', 'content_type_id', 'link')
                ->addFieldDependence('page_id', 'link_id', 'page')
                ->addFieldDependence('category_id', 'content_type_id', 'link')
                ->addFieldDependence('category_id', 'link_id', 'category')
                /**
                 * Show Content
                 */
                ->addFieldDependence('contents_id', 'content_type_id', 'content')
                /**
                 * Show Column
                 */
                ->addFieldDependence('column_id', 'content_type_id', array('product'))
                ->addFieldDependence('column_id', 'product_type_id', array('bestseller', 'mostview'))
                /**
                 * Show Product
                 */
                // product type
                ->addFieldDependence('product_type_id', 'content_type_id', 'product')
                // product show type grid
                ->addFieldDependence('product_show_type_id', 'content_type_id', 'product')
                ->addFieldDependence('product_show_type_id', 'product_type_id', 'select')
                // product chooser
                ->addFieldDependence('product_sku_id', 'content_type_id', 'product')
                ->addFieldDependence('product_sku_id', 'product_type_id', 'select')
                /**
                 * Show Category
                 */
                ->addFieldDependence('category_type_id', 'content_type_id', 'category')
                ->addFieldDependence('categories_list_id', 'content_type_id', 'category')
                ->addFieldDependence('categories_list_id', 'category_type_id', 'select')


        );

        $this->setChild('form_after',
                $this->getLayout()->createBlock('categorytab/adminhtml_categorytab_edit_tab_main')
            );

        return parent::_prepareForm();
    }


    public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Menu Content');
    }

    public function getTabTitle()
    {
        return Mage::helper('adminhtml')->__('Menu Content');
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