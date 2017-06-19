<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 27/08/2015
 * Time: 22:02
 */
class Unet_Megamenu_Block_Adminhtml_Megamenu_Renderer_Sort extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Input {
    public function render(Varien_Object $row){
        $html = '<input type="number" ';
        $html .= 'name="' . $this->getColumn()->getId() . '" ';
        $html .= 'value="' . $row->getData($this->getColumn()->getIndex()) . '"';
        $html .= 'class="input-text ' . $this->getColumn()->getInlineCss() . '"/>';

        /**
         * Custom
         */
        $html .= '<button onclick="updateField(this, '.$row->getItem_id().'); return false;">Update</button>';
        $html .= '<style>
                    .grid td input.input-text {
                    width: 50%;
                    margin-right: 10px;
                }
                </style>';
        return $html;
    }
}