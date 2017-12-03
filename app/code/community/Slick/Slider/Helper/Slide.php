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
 * Slide helper
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Helper_Slide extends Mage_Core_Helper_Abstract
{

    /**
     * get base files dir
     *
     * @access public
     * @return string
     * @author Ali Kazim
     */
    public function getFileBaseDir()
    {
        return Mage::getBaseDir('media').DS.'slide'.DS.'file';
    }

    /**
     * get base file url
     *
     * @access public
     * @return string
     * @author Ali Kazim
     */
    public function getFileBaseUrl()
    {
        return Mage::getBaseUrl('media').'slide'.'/'.'file';
    }
}
