<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 19/08/2015
 * Time: 09:59
 */
class Unet_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Renderer_Product extends Varien_Data_Form_Element_Abstract
{
    protected $_element;
    public function getElementHtml()
    {
        $url = $this->getUrl();
        $html = '<input type="text" id="'.$this->getHtmlId().'" class="input-text element-value-changer" name="'.$this->getName()
            .'" value="'.$this->getEscapedValue().'" '.$this->serialize($this->getHtmlAttributes()).'/>'."";
        $html .= '&nbsp;<a href="#" id="chooser-button" onclick="'.$url.'"><img class="v-middle rule-chooser-trigger" src="'.Mage::getDesign()->getSkinUrl('images/rule_chooser_trigger.gif').'" /></a>';
        $html .= $this->getAfterElementHtml();
        return $html;
    }
}
