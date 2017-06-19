<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 17/08/2015
 * Time: 09:24
 */
class Unet_Megamenu_Model_Megamenu extends Mage_Core_Model_Abstract {
    protected function _construct(){
        $this->_init('megamenu/megamenu');
    }

    /**
     * @return array for display status option
     */

    public function toStatusOption(){
        return array(
            array(
                'value' => 1,
                'label' => Mage::helper('megamenu')->__('Enable'),
            ),
            array(
                'value' => 0,
                'label' => Mage::helper('megamenu')->__('Disable'),
            ),
        );
    }

    /**
     * @return array for display menu type option
     */
    public function toMenuTypeOption(){
        return array(
            array(
                'value' => 'topmenu',
                'label' => Mage::helper('megamenu')->__('Top Menu'),
            ),
//            array(
//                'value' => 'leftmenu',
//                'label' => Mage::helper('megamenu')->__('Left Menu'),
//            ),
        );
    }

    /**
     * @return array for display content type option
     */
    public function toContentTypeOption(){
        return array(
            array(
                'value' => '',
                'label' => Mage::helper('megamenu')->__('--Please Select'),
            ),
            array(
                'value' => 'link',
                'label' => Mage::helper('megamenu')->__('Anchor Link'),
            ),
            array(
                'value' => 'content',
                'label' => Mage::helper('megamenu')->__('Content'),
            ),
            array(
                'value' => 'product',
                'label' => Mage::helper('megamenu')->__('Products'),
            ),
            array(
                'value' => 'category',
                'label' => Mage::helper('megamenu')->__('Categories'),
            ),
            array(
                'value' => 'login',
                'label' => Mage::helper('megamenu')->__('Login'),
            ),
            array(
                'value' => 'contact',
                'label' => Mage::helper('megamenu')->__('Contact us'),
            ),
        );
    }

    /**
     * List all cms page
     */
    public function toCmsPageOption(){
        $pages = Mage::getModel('cms/page')->getCollection()->getData();
        $options = array();
        $i = 0;
        foreach($pages as $key => $value){
            $options[$i]['label'] = $value['title'];
            $options[$i]['value'] = $value['identifier'];
            $i++;
        }
        return $options;
    }
    /**
     * @return array for display category tree
     */
    public function buildCategoriesMultiselectValues(Varien_Data_Tree_Node $node, $values, $level = 0)
    {
        $level++;

        $values[$node->getId()]['value'] =  $node->getId();

        $values[$node->getId()]['label'] = str_repeat("--", $level-1) . $node->getName();


        foreach ($node->getChildren() as $child)
        {
            $values = $this->buildCategoriesMultiselectValues($child, $values, $level);
        }

        return $values;
    }

    public function toCategoriesOption($addEmpty = true)
    {
        $tree = Mage::getResourceSingleton('catalog/category_tree')->load();

        $store = Mage::app()->getStore()->getStoreId();
        if(!$store){
            $store = 1;
        }
        $parentId = Mage::app()->getStore($store)->getRootCategoryId();

        $tree = Mage::getResourceSingleton('catalog/category_tree')->load();

        $root = $tree->getNodeById($parentId);

        if($root && $root->getId() == 1)
        {
            $root->setName(Mage::helper('catalog')->__('Root'));
        }

        $collection = Mage::getModel('catalog/category')->getCollection()
            ->setStoreId($store)
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('is_active');

        $tree->addCollectionData($collection, true);

        return $this->buildCategoriesMultiselectValues($root, array());
    }
}