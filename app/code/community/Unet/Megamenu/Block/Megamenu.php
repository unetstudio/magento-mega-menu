<?php

/**
 * Created by PhpStorm.
 * User: duc
 * Date: 18/08/2015
 * Time: 11:22
 */
class Unet_Megamenu_Block_Megamenu extends Mage_Page_Block_Html_Topmenu
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('Unet/megamenu/megamenu.phtml');
    }

    protected function _getHtml()
    {
        return "";
    }

    public function getProductsselector()
    {
        if (!$this->hasData('productsselector')) {
            $this->setData('productsselector', Mage::registry('productsselector'));
        }
        return $this->getData('productsselector');
    }

    /**
     * get mega menu
     */
    public function getMegamenu()
    {
        $menus = Mage::getModel("megamenu/megamenu")->getCollection();
        $menus->setOrder('sort_order', 'ASC');
        $result = "";
        foreach ($menus as $item) {
            if ($item->getStatus() == 1) {
                $result .= $this->getItem($item);
            }
        }

        /**
         * Select Effect
         */
        $effect = Mage::getStoreConfig('megamenu_config/general/menu_effect');
        if ($effect == 'click') {
            $result .= '<script type="text/javascript" src="http://localhost/magento.vn/js/Unet/megamenu/main_click.js"></script>';
        } else {
            $result .= '<script type="text/javascript" src="http://localhost/magento.vn/js/Unet/megamenu/main_hover.js"></script>';
        }
        return $result;
    }

    /**
     * @param $item
     * @return string of content_type of item
     */
    public function getItem($item)
    {
        $result = "";
        $content_type = explode("_", $item->getContent_type());
        switch ($content_type[0]) {
            case 'link':
                $result .= $this->getLinkItem($item);
                break;
            case 'content':
                $result .= $this->getContentItem($item);
                break;
            case 'product':
                $result .= $this->getProductItem($item);
                break;
            case 'category':
                $result .= $this->getCategoryItem($item);
                break;
            case 'login':
                $result .= $this->getLoginItem($item);
                break;
            case 'contact':
                $result .= $this->getContactItem($item);
                break;
        }
        return $result;
    }

    /**
     * @param $item
     * @return string contain anchor link
     */
    public function getLinkItem($item)
    {
        return '<li>
                <a href="' . $item->getItem_link() . '">' . $item->getItem_name() . '</a>
            </li>';
    }

    /**
     * @param $item
     * @return string contain content item
     */
    public function getContentItem($item)
    {
        $content = "";
        $content .= '<li class="has-childrens">
                    <a href="#">' . $item->getItem_name() . '</a>
                    <ul class="cd-nav-icons megamenu-content is-hidden">';
        $content .= $item->getContent();
        $content .= '</ul></li>';
        return $content;
    }

    /**
     * @param $item
     * @return string contain login item
     */
    public function getLoginItem($item)
    {
        return '<li class="has-childrens">
                <a href="#">' . $item->getItem_name() . '</a>
               <ul class="form-list cd-nav-icons is-hidden">
                <form action="' . $this->getUrl('customer/account/loginPost') . '" method="post" id="login-form" class="scaffold-form">
                    ' . $this->getBlockHtml('formkey') . '
                        <li style="float: none;">
                            <label for="email" class="required"><em>*</em>Email Address</label>
                            <div class="input-box">
                                <input type="email" autocapitalize="off" autocorrect="off" spellcheck="false" name="login[username]" value="" id="email" class="input-text required-entry validate-email" title="Email Address">
                            </div>
                        </li>
                        <li style="float: none;">
                            <label for="pass" class="required"><em>*</em>Password</label>
                            <div class="input-box">
                                <input type="password" name="login[password]" class="input-text required-entry validate-password" id="pass" title="Password">
                            </div>
                        </li>
                        <li style="float: none;">
                            <a style="color: #07c; border: none;" href="http://localhost/magento.org/index.php/customer/account/forgotpassword/" class="f-left">Forgot Your Password?</a>
                        </li>
                        <li style="float: none;">
                            <button type="submit" class="button" title="Login" name="send" id="send2"><span><span>Login</span></span></button>
                        </li>
                </form>
               </ul>
            </li>';
    }

    /**
     * @param $item
     * @return string contain contact form
     */
    public function getContactItem($item)
    {
        return '<li class="has-childrens">
	<a href="#">' . $item->getItem_name() . '</a>
	<ul class="cd-nav-icons is-hidden">
		<form action="' . $this->getUrl('contacts/index/post') . '" id="contactForm" method="post" class="scaffold-form">
			<div class="fieldset">
				<ul class="form-list">
					<li class="fields">
						<div class="field">
							<label for="name" class="required"><em>*</em>Name</label>
							<div class="input-box">
								<input name="name" id="name" title="Name" value="" class="input-text required-entry" type="text">
							</div>
						</div>
						<div class="field">
							<label for="email" class="required"><em>*</em>Email</label>
							<div class="input-box">
								<input name="email" id="email" title="Email" value="" class="input-text required-entry validate-email" type="email" autocapitalize="off" autocorrect="off" spellcheck="false">
							</div>
						</div>
					</li>
					<li style="float: none;">
						<label for="telephone">Telephone</label>
						<div class="input-box">
							<input name="telephone" id="telephone" title="Telephone" value="" class="input-text" type="tel">
						</div>
					</li>
					<li>
						<label for="comment" class="required"><em>*</em>Comment</label>
						<div class="input-box">
							<textarea name="comment" id="comment" title="Comment" class="required-entry input-text" cols="5" rows="3"></textarea>
						</div>
					</li>
				</ul>
			</div>
			<div class="buttons-set" style="float: left">
				<input type="text" name="hideit" id="hideit" value="" style="display:none !important;">
				<button type="submit" title="Submit" class="button"><span><span>Submit</span></span></button>
			</div>
		</form>
	</ul>
</li>';
    }

    /**
     * @param $item
     * @return string contain product item
     */
    public function getProductItem($item)
    {
        $result = "";
        $content_type = explode("_", $item->getContent_type());
        switch ($content_type[1]) {
            case 'bestseller':
                $result .= $this->getProductBMItem($item);
                break;
            case 'mostview':
                $result .= $this->getProductBMItem($item);
                break;
            case 'select':
                if ($content_type[2] == 'grid') {
                    $result .= $this->getProductGridItem($item);
                } elseif ($content_type[2] == 'list') {
                    $result .= $this->getProductListingItem($item);
                }
                break;
        }
        return $result;
    }

    /**
     * get product bestseller or mostview
     */
    public function getProductBMItem($item)
    {
        $result = "";
        $result .= '<li class="has-childrens">
				<a href="#">' . $item->getItem_name() . '</a>
				<ul class="cd-nav-gallery product-grid is-hidden">
					<li class="go-back"><a href="#">Menu</a></li>';

        $product_ids = explode(",", $item->getContent());
        foreach ($product_ids as $id) {
            if ($id and !empty($id)) {
                $_product = Mage::getModel('catalog/product')->load(trim($id));
                if (Mage::getStoreConfig('megamenu_config/product_grid/visible_name')) {
                    $name = '<h4>' . $_product->getName() . '</h4>';
                }
                if (Mage::getStoreConfig('megamenu_config/product_grid/visible_price')) {
                    $price = '<h4 id="price">' . Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol() . $_product->getPrice() . '</h4>';
                }
                $result .= '<li>
						<a class="cd-nav-item" href="' . Mage::getBaseUrl() . '/' . $_product->getUrl_path() . '">
							<img src="' . Mage::helper('catalog/image')->init($_product, 'thumbnail') . '" alt="Product Image">
                            ' . $name . '' . $price . '
						</a>
					</li>';
            }
        }

        $result .= '</ul></li>';
        return $result;
    }

    /**
     * get product grid
     */
    public function getProductGridItem($item)
    {
        $result = "";
        $result .= '<li class="has-childrens">
				<a href="#">' . $item->getItem_name() . '</a>
				<ul class="cd-nav-gallery product-grid is-hidden">
					<li class="go-back"><a href="#">Menu</a></li>';

        $product_sku = explode(",", $item->getContent());
        foreach ($product_sku as $sku) {
            if ($sku and !empty($sku)) {
                $_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($sku));
                if (Mage::getStoreConfig('megamenu_config/product_grid/visible_name')) {
                    $name = '<h4>' . $_product->getName() . '</h4>';
                }
                if (Mage::getStoreConfig('megamenu_config/product_grid/visible_price')) {
                    $price = '<h4 id="price">' . Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol() . $_product->getPrice() . '</h4>';
                }
                $result .= '<li>
						<a class="cd-nav-item" href="' . Mage::getBaseUrl() . '/' . $_product->getUrl_path() . '">
							<img src="' . Mage::helper('catalog/image')->init($_product, 'thumbnail') . '" alt="Product Image">
							' . $name . '' . $price . '
						</a>
					</li>';
            }
        }

        $result .= '</ul></li>';
        return $result;
    }

    /**
     * get product listing
     */
    public function getProductListingItem($item)
    {
        $result = "";
        $result .= '<li class="has-childrens">
				<a href="#">' . $item->getItem_name() . '</a>
				<ul class="cd-nav-icons is-hidden">
					<li class="go-back"><a href="#">Menu</a></li>';
        $product_sku = explode(",", $item->getContent());
        foreach ($product_sku as $sku) {
            $_product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($sku));
            $result .= '<li>
						<a class="cd-nav-item" href="' . Mage::getBaseUrl() . '/' . $_product->getUrl_path() . '">
						    <h5>' . $_product->getName() . '</h5>
						</a>
					</li>';
        }
        $result .= '</ul></li>';
        return $result;
    }

    /**
     * get all categories item
     */
    public function getCategoryItem($item)
    {
        $result = "";
        $content_type = explode("_", $item->getContent_type());
        $rootcatId = Mage::app()->getStore()->getRootCategoryId();
        $categories = Mage::getModel('catalog/category')->getCategories($rootcatId);
        $result .= '<li class="has-childrens">
                            <a href="#">' . $item->getItem_name() . '</a>';
        switch ($content_type[1]) {
            case 'all':
                $result .= $this->getAllCategoryItem($categories, "", false);
                break;
            case 'select':
                $categories_select_ids = explode(",", $item->getContent());
                $categories_ids = array();
                foreach ($categories_select_ids as $id) {
                    $categories_ids[] = trim($id);
                }
                $result .= $this->getAllCategoryItem($categories, $categories_ids, false);
                break;
        }
        $result .= '</li>';
        return $result;
    }

    public function getAllCategoryItem($categories, $flag, $categories_select_ids = "")
    {
        if (!$flag) {
            $array = '<ul class="cd-secondary-nav is-hidden">';
        } else {
            $array = '<ul class="is-hidden">';
        }
        foreach ($categories as $category) {
            $id = $category->getId();
            if (is_array($categories_select_ids)) {
                if (!in_array($id, $categories_select_ids)) {
                    continue;
                }
            }
            $cat = Mage::getModel('catalog/category')->load($id);
            $count = $cat->getProductCount();
            if ($category->hasChildren()) {
                $array .= '<li class="go-back"><a href="#">Back</a></li>';
                $array .= '<li class="has-children">';
                $array .= '<a href="#">
                        ' . $category->getName() . '(' . $count . ')
                    </a>' . "\n";
            } else {
                $array .= '<li class="go-back"><a href="#">Back</a></li>';
                $array .= '<li>';
                $array .= '<a href="' . Mage::getUrl($cat->getUrlPath()) . '">
                        ' . $category->getName() . '(' . $count . ')
                    </a>' . "\n";
            }

            if ($category->hasChildren()) {
                $children = Mage::getModel('catalog/category')->getCategories($category->getId());
                $array .= $this->getAllCategoryItem($children, $categories_select_ids, true);
            }
            $array .= '</li>';
        }
        return $array . '</ul>';
    }

    /**
     * Custom style sheet
     */
    public function style()
    {
        $style = "<style>";
        /**
         * Menu
         */
        // Width
        $menu_width = (Mage::getStoreConfig('megamenu_config/menu/width') != "")
            ? Mage::getStoreConfig('megamenu_config/menu/width') : 'auto';
        // Height
        $menu_height = (Mage::getStoreConfig('megamenu_config/menu/height') != "")
            ? Mage::getStoreConfig('megamenu_config/menu/height') : 'auto';
        // Background
        $menu_background = (Mage::getStoreConfig('megamenu_config/menu/background') != "FFFFFF")
            ? Mage::getStoreConfig('megamenu_config/menu/background') : 'transparent';
        $style .= "
                .cd-primary-nav {
                    width: " . $menu_width . "px !important;
                    height: " . $menu_height . "px !important;
                    background: #" . $menu_background . " !important;
                }
        ";
        /**
         * Item
         */
        // Item Alignment
        $item_align = (Mage::getStoreConfig('megamenu_config/item/item_align') != "center")
            ? Mage::getStoreConfig('megamenu_config/item/item_align') : "center";
        // Item Width
        $item_width = (Mage::getStoreConfig('megamenu_config/item/item_width') != "")
            ? Mage::getStoreConfig('megamenu_config/item/item_width') : "auto";
        // Item Height
        $item_height = (Mage::getStoreConfig('megamenu_config/item/') != "80")
            ? Mage::getStoreConfig('megamenu_config/item/item_height') : "80";
        // Item Font Size
        $item_size = (Mage::getStoreConfig('megamenu_config/item/item_size') != "100")
            ? Mage::getStoreConfig('megamenu_config/item/item_size') : "100";
        // Item Label
        $item_label = (Mage::getStoreConfig('megamenu_config/item/item_label') != "none")
            ? Mage::getStoreConfig('megamenu_config/item/item_label') : "none";
        // Item Background
        $item_background = (Mage::getStoreConfig('megamenu_config/item/item_background') != "FFFFFF")
            ? Mage::getStoreConfig('megamenu_config/item/item_background') : "FFFFFF";
        // Item Color
        $item_color = (Mage::getStoreConfig('megamenu_config/item/item_color') != "2E3233")
            ? Mage::getStoreConfig('megamenu_config/item/item_color') : "2E3233";
        // Item Select Background
        $item_select_background = (Mage::getStoreConfig('megamenu_config/item/item_select_background') != "FFFFFF")
            ? Mage::getStoreConfig('megamenu_config/item/item_select_background') : "FFFFFF";
        // Item Select Color
        $item_select_color = (Mage::getStoreConfig('megamenu_config/item/item_select_color') != "69AA6F")
            ? Mage::getStoreConfig('megamenu_config/item/item_select_color') : "69AA6F";

        $style .= "
            .cd-primary-nav > li > a {
                text-align: " . $item_align . " !important;
                width: " . $item_width . "px !important;
                height: " . $item_height . "px !important;
                line-height: " . $item_height . "px !important;
                font-size: " . $item_size . "% !important;
                text-transform: " . $item_label . " !important;
                background: #" . $item_background . " !important;
                color: #" . $item_color . " !important;
            }
            .cd-primary-nav > li > a:hover {
                background: #" . $item_select_background . " !important;
                color: #" . $item_select_color . " !important;
                box-shadow: inset 0 -2px 0 #" . $item_select_color . " !important;
            }
            .cd-primary-nav .cd-secondary-nav > li > a {
                 color: #" . $item_select_color . " !important;
            }
            li.has-childrens ul.selected {
                position: absolute !important;
                top: " . $item_height . "px !important;
            }
        ";
        /**
         * Submenu
         */
        // Submenu Width
        $sub_width = (Mage::getStoreConfig('megamenu_config/submenu/width') != "92")
            ? Mage::getStoreConfig('megamenu_config/submenu/width') : "92";
        // Submenu Background
        $sub_background = (Mage::getStoreConfig('megamenu_config/submenu/background') != "FFFFFF")
            ? Mage::getStoreConfig('megamenu_config/submenu/background') : "FFFFFF";
        // Submenu Link Color
        $sub_link_color = (Mage::getStoreConfig('megamenu_config/submenu/link_color') != "2E3233")
            ? Mage::getStoreConfig('megamenu_config/submenu/link_color') : "2E3233";
        // Submenu Link Hover Color
        $sub_link_hover_color = (Mage::getStoreConfig('megamenu_config/submenu/link_hover_color') != "69AA6F")
            ? Mage::getStoreConfig('megamenu_config/submenu/link_hover_color') : "69AA6F";
        $style .= "
            // category link
            li.has-childrens ul.selected {
                width: " . $sub_width . "vw !important;
                background: #" . $sub_background . " !important;
            }
            li.has-childrens ul.selected li a {
                color: #" . $sub_link_color . " !important;
            }

            .has-children > a:hover::before, .has-children > a:hover::after,
            .go-back a:hover::before, .go-back a:hover::after {
                background: #" . $sub_link_hover_color . " !important;
            }

            li.has-childrens ul.selected li > a:hover {
                color: #" . $sub_link_hover_color . " !important;
            }

            // product link
            .cd-primary-nav .cd-nav-icons .cd-nav-item h5 {
                color: #" . $sub_link_color . " !important;
            }
            .cd-primary-nav .cd-nav-icons .cd-nav-item:hover h5 {
                color: #" . $sub_link_hover_color . " !important;
            }
        ";

        /**
         * Product Grid
         */
        // Image Hover Color
        $image_hover_color = (Mage::getStoreConfig('megamenu_config/product_grid/image_hover_color') != "3399CC")
            ? Mage::getStoreConfig('megamenu_config/product_grid/image_hover_color') : "3399CC";
        $style .= "
            ul.product-grid img:hover {
                border: 1px solid #" . $image_hover_color . " !important;
            }
            ul.product-grid h4#price {
                color: #" . $image_hover_color . " !important;
            }
        ";

        $style .= "</style>";
        return $style;
    }
}
