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
 * Slide admin block
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
class Slick_Slider_Block_Adminhtml_Slide extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ali Kazim
     */
    public function __construct()
    {
        $this->_controller         = 'adminhtml_slide';
        $this->_blockGroup         = 'slick_slider';
        parent::__construct();
        $this->_headerText         = Mage::helper('slick_slider')->__('Slide');
        $this->_updateButton('add', 'label', Mage::helper('slick_slider')->__('Add Slide'));

    }
}
