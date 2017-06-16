<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 13/08/2015
 * Time: 08:47
 */
class Mdg_Megamenu_Block_Adminhtml_Megamenu_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId('megamenu_list_grid');
        $this->setDefaultSort('item_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);

    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('megamenu/megamenu')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('item_id', array(
            'index' => 'item_id',
            'header' => Mage::helper('megamenu')->__('Item Id'),
            'width' => '50px',
        ));
        $this->addColumn('item_name', array(
            'index' => 'item_name',
            'header' => Mage::helper('megamenu')->__('Item Name'),
            'width' => '200px',
        ));
//        $this->addColumn('item_link', array(
//            'index' => 'item_link',
//            'header' => Mage::helper('megamenu')->__('Item Link'),
//            'width' => '300px',
//            'renderer' => 'megamenu/adminhtml_megamenu_renderer_link',
//        ));
        $this->addColumn('sort_order', array(
            'index' => 'sort_order',
            'header' => Mage::helper('megamenu')->__('Sort Order'),
            'align' => 'center',
            'renderer' => 'megamenu/adminhtml_megamenu_renderer_sort',
            'width' => '200px',
        ));
        $this->addColumn('menu_type', array(
            'index' => 'menu_type',
            'header' => Mage::helper('megamenu')->__('Menu Type'),
            'width' => '150px',
            'type' => 'options',
            'options' => array(
                'topmenu' => 'Top Menu',
                'leftmenu' => 'Left Menu',
            ),
        ));
        $this->addColumn('content_type', array(
            'index' => 'content_type',
            'header' => Mage::helper('megamenu')->__('Content Type'),
            'width' => '150px',
            'renderer' => 'megamenu/adminhtml_megamenu_renderer_contenttype',
        ));
//        $this->addColumn('column', array(
//            'index' => 'column',
//            'header' => Mage::helper('megamenu')->__('Columns'),
//        ));
//        $this->addColumn('content', array(
//            'index' => 'content',
//            'header' => Mage::helper('megamenu')->__('Content'),
//            'width' => '150px',
//        ));
        $this->addColumn('created_at', array(
            'index' => 'created_at',
            'header' => Mage::helper('megamenu')->__('Created At'),
            'width' => '150px',
            'type' => 'date',
        ));
        $this->addColumn('status', array(
            'index' => 'status',
            'header' => Mage::helper('megamenu')->__('Status'),
            'type' => 'options',
            'options' => array(
                0 => 'Disabled',
                1 => 'Enabled',
            ),
            'width' => '100px',
        ));

        $this->addColumn('action', array(
            'header' => Mage::helper('catalog')->__('Action'),
            'width' => '100px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('catalog')->__('Edit Item'),
                    'image' => Mage::getDesign()->getSkinUrl('images/rule_chooser_trigger.gif'),
                    'url' => array(
                        'base' => '*/*/edit',
                        'params' => array('store' => $this->getRequest()->getParam('store'))
                    ),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('megamenu')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('megamenu')->__('XML'));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getItem_id()));
    }

    /**
     * Display massaction
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('item_id');
        $this->getMassactionBlock()->setFormFieldName('megamenu');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('megamenu')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('megamenu')->__('Are you sure?'),
        ));

        /* Mass change status */
        $statuses = array(
            '' => "",
            '0' => Mage::helper('megamenu')->__('Disabled'),
            '1' => Mage::helper('megamenu')->__('Enabled'),
        );
        //array_unshift($statuses, array('label' => '', 'value' => ''));

        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('megamenu')->__('Change Status'),
            'url' => $this->getUrl('*/*/massStatus', array(
                '_current' => true,
            )),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('megamenu')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }
}