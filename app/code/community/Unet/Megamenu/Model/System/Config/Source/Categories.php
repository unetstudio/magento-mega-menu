<?php
class Unet_Megamenu_Model_System_Config_Source_Categories
{
    //    public function toOptionArray()
//    {
//        $categories = Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true);
//        Zend_Debug::dump($categories);
//        return $categories->toOptionArray();
//    }
    public function buildCategoriesMultiselectValues(Varien_Data_Tree_Node $node, $values, $level = 0)
    {
        $level++;

        $values[$node->getId()]['value'] =  $node->getId();

        $values[$node->getId()]['label'] = str_repeat("--", $level-1) . $node->getName();


        foreach ($node->getChildren() as $child) {
            $values = $this->buildCategoriesMultiselectValues($child, $values, $level);
        }

        return $values;
    }

    public function toOptionArray($addEmpty = true)
    {
        $tree = Mage::getResourceSingleton('catalog/category_tree')->load();

        $store = Mage::app()->getStore()->getStoreId();
        if (!$store) {
            $store = 1;
        }
        $parentId = Mage::app()->getStore($store)->getRootCategoryId();

        $tree = Mage::getResourceSingleton('catalog/category_tree')->load();

        $root = $tree->getNodeById($parentId);

        if ($root && $root->getId() == 1) {
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
