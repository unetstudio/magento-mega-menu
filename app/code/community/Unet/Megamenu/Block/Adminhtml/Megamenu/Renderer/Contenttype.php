<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 21/08/2015
 * Time: 08:48
 */
class Unet_Megamenu_Block_Adminhtml_Megamenu_Renderer_Contenttype extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Text {
    public function render(Varien_Object $row){
        $type = $row->getContent_type();

        $content_type = explode('_', $type);
        switch($content_type[0]) {
            case 'link':
                switch($content_type[1]){
                    case 'text': return 'Anchor Link'; break;
                    case 'page': return 'Page Link'; break;
                    case 'category': return 'Category Link'; break;
                }
                break;
            case 'product':
                switch($content_type[1]){
                    case 'bestseller': return 'Bestseller Product'; break;
                    case 'mostview': return 'Most View Product'; break;
                    case 'select':
                        if($content_type[2] == 'grid') return 'Product Selected Grid';
                        else return 'Product Selected Listing';
                        break;
                }
                break;
            case 'category':
                if($content_type[1] == 'all') return 'All Categories';
                else return 'Categories Selected';
                break;
            case 'login':
                return "Login Form";
            case 'contact':
                return "Contact Form";
            case 'content':
                return "Contents";
            default:
                return ucwords($content_type[0]);
                break;
        }

    }
}