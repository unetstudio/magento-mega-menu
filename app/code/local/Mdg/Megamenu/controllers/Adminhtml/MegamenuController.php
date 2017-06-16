<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 17/08/2015
 * Time: 14:29
 */
class Mdg_Megamenu_Adminhtml_MegamenuController extends Mage_Adminhtml_Controller_Action {
    public function indexAction()
    {
        $this->loadLayout()->_setActiveMenu('megamenu')
            ->_title($this->__('Megamenu'));
        $this->renderLayout();
    }

    public function gridAction(){
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('megamenu/adminhtml_megamenu_grid')->toHtml()
        );
    }

    public function newAction(){
        $this->_forward('edit');
    }

    public function preparaDataDisplay($model){
       if($model->getItem_id()){
           $init = $model->getData();
           $data = array(
               'item_name' => $init['item_name'],
               'item_link' => $init['item_link'],
               'sort_order' => $init['sort_order'],
               'menu_type' => $init['menu_type'],
               'status' => $init['status'],
           );
           $content_type = explode('_', $init['content_type']);
           switch($content_type[0]){
               case 'link':
                   $type = $content_type[1];
                   switch($type){
                       case 'text':
                           $data['text_link'] = $init['content'];
                           break;
                       case 'page':
                           $data['page_link'] = $init['content'];
                           break;
                       case 'category':
                           $data['category_link'] = $init['content'];
                           break;
                   }
                   $data['link_type'] = $type;
                   break;
               case 'content':
                   $data['contents'] = $init['content'];
                   break;
               case 'product':
                   $product_type = $content_type[1];
                   switch($product_type){
                       case 'bestseller': break;
                       case 'mostview': break;
                       case 'select':
                           $data['product_show_type'] = $content_type[2];
                           $data['product_sku'] = $init['content'];
                           break;
                   }
                   $data['column'] = $init['column'];
                   $data['product_type'] = $product_type;
                   break;
               case 'category':
                   $category_type = $content_type[1];
                   $data['category_type'] = $category_type;
                    if($category_type == "select"){
                        $data['categories_list'] = explode(",", $init['content']);
                    }
                   $data['column'] = $init['column'];
                   break;
           }
           $data['content_type'] = $content_type[0];
           return $data;
       }
    }

    public function editAction(){
        $this->_title($this->__('Megamenu Item'));
        $model = Mage::getModel('megamenu/megamenu');
        $item_id = $this->getRequest()->getParam('id');
        if($item_id){
            $model->load($item_id);
            if(!$model->getItem_id()){
                Mage::getSingleton('adminhtml/session')->addError('Item does not exist');
                $this->_redirect('*/*/');
            }
        }
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if($data){
            $model->setData($data)->setId($item_id);
        }
        $dataForm = $this->preparaDataDisplay($model);
//
        $model->setData($dataForm)->setId($item_id);
        Mage::register('megamenu', $model);

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Process data before save
     */

    public function prepareDataSave(){
        if($this->getRequest()->getPost()){
            $data = array(
                'item_name' => $this->getRequest()->getParam('item_name'),
                'item_link' => $this->getRequest()->getParam('item_link'),
                'sort_order' => $this->getRequest()->getParam('sort_order'),
                'menu_type' => $this->getRequest()->getParam('menu_type'),
                'status' => $this->getRequest()->getParam('status'),
            );
            $content_type = $this->getRequest()->getParam('content_type');
            switch($content_type){
                case 'link':
                    $type = $this->getRequest()->getParam('link_type');
                    switch($type){
                        case 'text':
                            $data['item_link'] = $this->getRequest()->getParam('text_link');
                            $data['content'] = $this->getRequest()->getParam('text_link');
                            break;
                        case 'page':
                            $data['item_link'] = Mage::getBaseUrl().$this->getRequest()->getParam('page_link');
                            $data['content'] = $this->getRequest()->getParam('page_link');
                            break;
                        case 'category':
                            $category_id = $this->getRequest()->getParam('category_link');
                            $data['content'] = $category_id;
                            $data['item_link'] = Mage::getModel('catalog/category')->load($category_id)->getUrl();
                            break;
                    }
                    $data['content_type'] = "link_".$type;
                    break;
                case 'content':
                    $data['content_type'] = $content_type;
                    $data['column'] = 0;
                    $data['content'] = $this->getRequest()->getParam('contents');
                    break;
                case 'product':
                    $data['column'] = $this->getRequest()->getParam('column');
                    $product_type = $this->getRequest()->getParam('product_type');
                    switch($product_type){
                        case 'bestseller':
                            $data['content'] = $this->getBestseller($data['column']);
                            $data['content_type'] = $content_type."_".$product_type;
                            break;
                        case 'mostview':
                            $data['content'] = $this->getMostView($data['column']);
                            $data['content_type'] = $content_type."_".$product_type;
                            break;
                        case 'select':
                            $product_show_type = $this->getRequest()->getParam('product_show_type');
                            $data['content'] = $this->getRequest()->getParam('product_sku');
                            $data['content_type'] = $content_type."_select_".$product_show_type;
                            break;
                    }
                    break;
                case 'category':
                    $data['column'] = $this->getRequest()->getParam('column');
                    $category_type = $this->getRequest()->getParam('category_type');
                    if($category_type == "all"){
                        $data['content'] = $this->getAllCategories();
                        $data['content_type'] = $content_type."_".$category_type;
                    }
                    else if($category_type == "select"){
                        $content = $this->getRequest()->getParam('categories_list');
                        $data['content'] = implode(',', $content);
                        $data['content_type'] = $content_type."_".$category_type;
                    }
                    break;
                default:
                    $data['content_type'] = $content_type;
                    $data['column'] = 0;
                    $data['content'] = "";
                    break;
            }

            $data['created_at'] = now();
            $data['updated_at'] = now();
            return $data;
        }
    }

    public function getBestseller($number){
        $storeId = Mage::app()->getStore()->getId();
        $products = Mage::getResourceModel('reports/product_collection')
            ->addOrderedQty()
            ->addAttributeToSelect('*')
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->setOrder('ordered_qty', 'desc')
            ->setPageSize($number)->setCurPage(1); // most bestsellers on top
        Mage::getSingleton('catalog/product_status')
            ->addVisibleFilterToCollection($products);
//
//        Mage::getSingleton('catalog/product_visibility')
//            ->addVisibleInCatalogFilterToCollection($products);

        $data = "";
        foreach($products as $_product){
            $data .= $_product->getId().",";

        }
        $data = trim($data, ",");
        return $data;
//        Zend_Debug::dump($data);
//        exit;
    }

    public function getMostView($number){
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

//        Mage::getSingleton('catalog/product_visibility')
//            ->addVisibleInCatalogFilterToCollection($products);

        $products->setPageSize($number)->setCurPage(1);

        $data = "";
        foreach($products as $product){
            $data .= $product->getId().",";
        }
        $data = trim($data, ",");
        return $data;
    }

    public function getAllCategories(){
        $data = "";
        $category = Mage::getModel('catalog/category');
        $tree = $category->getTreeModel();
        $tree->load();
        $ids = $tree->getCollection()->getAllIds();
        if($ids){
            foreach($ids as $id){
                $data .= ",".$id;
            }
        }
        return trim($data, ",");
    }

    public function saveAction(){
        if($this->getRequest()->getPost()){
            $data = $this->prepareDataSave();
            $model = Mage::getModel('megamenu/megamenu');
            if($id = $this->getRequest()->getParam('item_id')){
                $model->load($id);
                $model->setId($id);
            }
            foreach($data as $index => $value){
                $model->setData($index, $value);
            }
          //Zend_Debug::dump($model);
            //exit;
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The item has been saved.'));
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction(){
        if($id = $this->getRequest()->getParam('id')){
            $model = Mage::getModel('megamenu/megamenu');
            $model->setId($id);
            try {
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The record has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch(Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessages());
            }
            catch(Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while deleting this item.'));
                Mage::logException($e);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return $this;
            }
        }
    }

    /**
     * Massaction delete
     */
    public function massDeleteAction(){
        $item_ids = $this->getRequest()->getParam('megamenu');
        if(!is_array($item_ids)){
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('adminhtml')->__('Please select items'));
        }
        else {
            try {
                foreach($item_ids as $id){
                    $model = Mage::getModel('megamenu/megamenu')
                        ->load($id);
                    $model->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d items were successfully deleted', count($item_ids))

                );
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Massaction change status
     */
    public function massStatusAction(){
        $item_ids = $this->getRequest()->getParam('megamenu');
        if(!is_array($item_ids)){
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('adminhtml')->__('Please select items'));
        }
        else {
            try {
                foreach($item_ids as $id){
                    $model = Mage::getModel('megamenu/megamenu')
                        ->load($id)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d items were successfully updated', count($item_ids))

                );
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Export CSV
     */
    public function exportCsvAction(){
        $filename = 'mehamenu.csv';
        $content = $this->getLayout()
            ->createBlock('megamenu/adminhtml_megamenu_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($filename, $content);
    }
     /**
      * Export XML
      */
    public function exportXmlAction(){
        $filename = 'mehamenu.xml';
        $content = $this->getLayout()
            ->createBlock('megamenu/adminhtml_megamenu_grid')
            ->getXml();
        $this->_prepareDownloadResponse($filename, $content);
    }

    /**
     * Reset megamenu configuration
     */
    public function resetAction(){
        $config = new Mage_Core_Model_Config();
        $collection = Mage::getModel('core/config_data')->getCollection()
            ->addFieldToFilter('path', array('like' => 'megamenu%'));
        foreach($collection as $item){
            $config->deleteConfig($item->getPath(), 'default', 0);
        }
        Mage::getSingleton('core/session')->addSuccess("Restore Mega Menu Configuration Success!");
        $this->_redirect('adminhtml/system_config/edit/section/megamenu_config/');
    }

    /**
     * Grid edit inline
     */
    public function updateSortAction(){
        $id = (int) $this->getRequest()->getParam('id');
        $sort_order = $this->getRequest()->getParam('sort_order');
        if($id){
            $model = Mage::getModel("megamenu/megamenu")->load($id);
            $model->setData('sort_order', $sort_order);
            $model->save();
        }
    }

    /**
     * Category tree
     */
    public function getCategoryTreeAction(){
//        echo '<h1>tree</h1>';
//        $rootcatId = Mage::app()->getStore()->getRootCategoryId();
//        $categories = Mage::getModel('catalog/category')->getCategories($rootcatId);
//        $result = '<li class="has-childrens">
//                            <a href="#">Tree</a>';
//        $result .= $this->getAllCategoryItem($categories);
//        $result .= '</li>';
//        echo $result;

        echo $this->getLayout()->createBlock('core/template')->setTemplate('mdg/megamenu/demo.phtml')->toHtml();
//        echo $this->getLayout()->createBlock('megamenu/adminhtml_megamenu')->toHtml();
//        echo $this->getLayout()->createBlock('adminhtml/catalog_product_edit')->toHtml();
//        echo $this->getLayout()->createBlock('adminhtml/catalog_product_edit_tabs')->toHtml();
//        echo $this->getLayout()->createBlock('adminhtml/catalog_product_edit_tab_categories')->setTemplate('catalog/product/edit/categories.phtml')->toHtml();

        exit;
    }

    /* get category tree */
    public function getAllCategoryItem($categories){
        $array = '<ul class="cd-secondary-nav">';
        foreach($categories as $category){
            $id = $category->getId();
            $cat = Mage::getModel('catalog/category')->load($id);
            $count = $cat->getProductCount();
            if($category->hasChildren())  {
                $array .= '<li class="go-back"><a href="#">Back</a></li>';
                $array .= '<li class="has-children">';
                $array .= '<a href="#">
                        '.$category->getName().'('.$count.')
                    </a>'."\n";
            }
            else  {
                $array .= '<li class="go-back"><a href="#">Back</a></li>';
                $array .= '<li>';
                $array .= '<a href="'.Mage::getUrl($cat->getUrlPath()).'">
                        '.$category->getName().'('.$count.')
                    </a>'."\n";
            }

            if($category->hasChildren()){
                $children = Mage::getModel('catalog/category')->getCategories($category->getId());
                $array .= $this->getAllCategoryItem($children);
            }
            $array .= '</li>';
        }
        return $array .'</ul>';
    }
}