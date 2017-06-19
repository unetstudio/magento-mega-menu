<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 17/08/2015
 * Time: 09:29
 */
class Unet_Megamenu_Model_Resource_Megamenu extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('megamenu/megamenu', 'item_id');
    }
}
