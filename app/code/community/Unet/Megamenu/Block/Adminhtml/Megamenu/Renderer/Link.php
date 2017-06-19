<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 21/08/2015
 * Time: 08:37
 */
class Unet_Megamenu_Block_Adminhtml_Megamenu_Renderer_Link extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return sprintf('<a target="_blank" href="%s">%s</a>', $row->getItem_link(), $row->getItem_link());
    }
}
