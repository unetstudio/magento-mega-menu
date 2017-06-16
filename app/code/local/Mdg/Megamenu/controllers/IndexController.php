<?php  
/**
 * 
 */
class Mdg_Megamenu_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction(){
        $this->loadLayout();
        $this->renderLayout();
    }

    public function showAction(){
        $model = Mage::getModel('megamenu/megamenu');
        var_dump($model);
    }

    public function selectAction(){
        $this->loadLayout();
        $this->renderLayout();
    }

    public function ajaxAction(){
       $value = $this->getRequest()->getParam('value');
        echo $value;
        exit;
    }

    /**
     * demo bestseller and most view
     */
    public static function bestsellerAction(){
        $storeId = Mage::app()->getStore()->getId();
        $products = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty()
            ->addAttributeToSelect('*')
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->setOrder('ordered_qty', 'desc'); // most bestsellers on top
        Mage::getSingleton('catalog/product_status')
            ->addVisibleFilterToCollection($products);

        Mage::getSingleton('catalog/product_visibility')
            ->addVisibleInCatalogFilterToCollection($products);

        $products->setPageSize(4)->setCurPage(1);
        $data = "";
        foreach($products as $product){
            $data .= ",".$product->getSku();
        }
        $data = trim($data, ",");
        $product_sku = explode(",", $data);
        foreach($product_sku as $sku){
            $_product = Mage::getModel('catalog/product')->loadByAttribute('sku', $sku);
        }
//        return $data;
        Zend_Debug::dump($data);
        exit;
    }

    public function mostviewAction(){
        $storeId = Mage::app()->getStore()->getId();
        $products = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty()
            ->addAttributeToSelect('*')
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->addViewsCount()
            ->setOrder();

        Mage::getSingleton('catalog/product_status')
            ->addVisibleFilterToCollection($products);

        Mage::getSingleton('catalog/product_visibility')
            ->addVisibleInCatalogFilterToCollection($products);

        $products->setPageSize(3)->setCurPage(1);

        $data = "";
        foreach($products as $product){
            $data .= ",".$product->getSku();
        }
        $data = trim($data, ",");
        Zend_Debug::dump($data);
        exit;
    }


}
