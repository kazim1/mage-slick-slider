<?php
/**
 * Slick_Slider extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Slick
 * @package        Slick_Slider
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Slider resource model
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Model_Resource_Slider extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Ali Kazim
     */
    public function _construct()
    {
        $this->_init('slick_slider/slider', 'entity_id');
    }
}
